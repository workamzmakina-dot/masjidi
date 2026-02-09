<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\PaymentGateway;
use App\Models\WebhookLog;
use App\Services\WishMoneyService;
use Illuminate\Http\Request;

class WishWebhookController extends Controller
{
    public function handle(Request $request, WishMoneyService $wishMoney)
    {
        $payload = $request->getContent();
        $signature = $request->header('X-Wish-Signature');

        $gateway = PaymentGateway::where('provider', 'wish')->first();

        $isValid = $gateway ? $wishMoney->verifySignature($payload, $signature, $gateway) : false;

        $statusCode = $isValid ? 200 : 400;

        WebhookLog::create([
            'provider' => 'wish',
            'external_id' => $request->input('id'),
            'payload' => $request->all(),
            'http_status' => $statusCode,
        ]);

        if (!$isValid) {
            return response()->json(['message' => 'Invalid signature.'], 400);
        }

        $reference = $request->input('reference');
        $donation = Donation::where('reference', $reference)->first();

        if ($donation) {
            $status = $request->input('status', 'failed');
            $donation->update(['status' => $status]);

            DonationTransaction::where('donation_id', $donation->id)
                ->latest()
                ->first()
                ?->update([
                    'status' => $status,
                    'response_payload' => $request->all(),
                    'paid_at' => $status === 'completed' ? now() : null,
                ]);
        }

        return response()->json(['message' => 'Webhook received.'], 200);
    }
}
