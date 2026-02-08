<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\PaymentGateway;
use App\Models\WebhookLog;
use App\Services\Payments\WishMoneyGateway;
use App\Jobs\GenerateDonationReceipt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class WishWebhookController extends Controller
{
    public function handle(Request $request)
    {
        $requestId = (string)Str::uuid();
        $payload = $request->all();
        
        $merchantId = $payload['merchant_id'] ?? null;
        $reference = $payload['order_reference'] ?? null;
        $txnId = $payload['transaction_id'] ?? null;

        // 1. Resolve Gateway/Mosque (Merchant ID is primary)
        $gatewayConfig = null;
        if ($merchantId) {
            $gatewayConfig = PaymentGateway::withoutGlobalScopes()
                ->where('merchant_id', $merchantId)
                ->where('provider', 'wish')
                ->first();
        }

        // Fallback: Resolve via Donation reference if merchant_id missing or not found
        $donation = null;
        if (!$gatewayConfig && $reference) {
            $donation = Donation::withoutGlobalScopes()->where('reference', $reference)->first();
            if ($donation) {
                $gatewayConfig = PaymentGateway::withoutGlobalScopes()
                    ->where('mosque_id', $donation->mosque_id)
                    ->where('provider', 'wish')
                    ->first();
            }
        } else if ($reference) {
            $donation = Donation::withoutGlobalScopes()->where('reference', $reference)->first();
        }

        // Log the incoming attempt
        $log = WebhookLog::create([
            'mosque_id' => $gatewayConfig?->mosque_id,
            'headers' => $request->headers->all(),
            'payload' => $payload,
            'signature' => $request->header('X-Wish-Signature'),
            'request_id' => $requestId,
            'received_at' => now(),
        ]);

        if (!$gatewayConfig) {
            $log->update(['error_message' => 'Unable to resolve tenant via merchant_id or reference.']);
            return response()->json(['error' => 'Tenant resolution failed'], 400);
        }

        // 2. Verify Signature
        $service = new WishMoneyGateway($gatewayConfig);
        if (!$service->verifyWebhook($request)) {
            $log->update(['error_message' => 'Signature verification failed.']);
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $log->update(['verified' => true]);

        if (!$donation) {
            $log->update(['error_message' => "Donation ref {$reference} not found."]);
            return response()->json(['error' => 'Donation not found'], 404);
        }

        // 3. Idempotency Check
        // If donation is already paid, ignore (already processed)
        if ($donation->status === 'paid') {
            $log->update(['processed_at' => now(), 'error_message' => 'Donation already marked as paid.']);
            return response()->json(['status' => 'already_processed']);
        }

        // Check for duplicate transaction ID
        $duplicate = DonationTransaction::withoutGlobalScopes()
            ->where('provider_txn_id', $txnId)
            ->exists();
            
        if ($duplicate) {
            $log->update(['processed_at' => now(), 'error_message' => 'Duplicate provider transaction ID.']);
            return response()->json(['status' => 'duplicate_transaction']);
        }

        // 4. Process Payment Update
        try {
            DB::transaction(function () use ($donation, $payload, $txnId) {
                $status = $payload['status']; // paid, failed, expired

                $donation->update(['status' => $status]);

                DonationTransaction::create([
                    'mosque_id' => $donation->mosque_id,
                    'donation_id' => $donation->id,
                    'provider_txn_id' => $txnId,
                    'status' => $status,
                    'amount' => $payload['amount'],
                    'currency' => $payload['currency'],
                    'response_payload' => $payload,
                    'paid_at' => $status === 'paid' ? now() : null,
                ]);

                if ($status === 'paid') {
                    // Queue receipt generation for Step 4 hardening
                    GenerateDonationReceipt::dispatch($donation);
                }
            });

            $log->update([
                'processed_at' => now(), 
                'event_type' => $payload['event'] ?? 'status_update'
            ]);

            return response()->json(['status' => 'ok']);

        } catch (\Exception $e) {
            $log->update(['error_message' => $e->getMessage()]);
            Log::error("Webhook Processing Error: " . $e->getMessage());
            return response()->json(['error' => 'Internal server error during processing'], 500);
        }
    }
}
