<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\PaymentGateway;
use App\Services\WishMoneyService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class DonationController extends Controller
{
    public function store(Request $request, WishMoneyService $wishMoney)
    {
        $data = $request->validate([
            'campaign_id' => ['required', 'integer', 'exists:campaigns,id'],
            'amount' => ['required', 'numeric', 'min:1'],
            'currency' => ['required', 'string', 'size:3'],
            'donor_name' => ['nullable', 'string'],
            'donor_email' => ['nullable', 'email'],
            'donor_phone' => ['nullable', 'string'],
        ]);

        $campaign = Campaign::findOrFail($data['campaign_id']);

        $donation = Donation::create([
            'campaign_id' => $campaign->id,
            'amount' => $data['amount'],
            'currency' => strtoupper($data['currency']),
            'donor_name' => $data['donor_name'] ?? null,
            'donor_email' => $data['donor_email'] ?? null,
            'donor_phone' => $data['donor_phone'] ?? null,
            'status' => 'pending',
            'reference' => Str::uuid()->toString(),
            'transaction_id' => Str::orderedUuid()->toString(),
            'metadata' => ['source' => 'public_api'],
        ]);

        $gateway = PaymentGateway::where('provider', 'wish')->where('is_enabled', true)->first();

        if (!$gateway) {
            return response()->json([
                'message' => 'Wish Money gateway not configured for this mosque.'
            ], 422);
        }

        $result = $wishMoney->createPayment($donation, $gateway);

        DonationTransaction::create([
            'donation_id' => $donation->id,
            'provider' => 'wish',
            'provider_txn_id' => $result['provider_id'],
            'status' => 'pending',
            'amount' => $donation->amount,
            'currency' => $donation->currency,
            'request_payload' => $result['request'],
            'response_payload' => $result['response'],
        ]);

        return response()->json([
            'donation' => $donation,
            'checkout_url' => $result['checkout_url'],
        ], 201);
    }
}
