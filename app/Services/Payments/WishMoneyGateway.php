<?php

namespace App\Services\Payments;

use App\Models\Donation;
use App\Models\DonationTransaction;
use App\Models\PaymentGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WishMoneyGateway
{
    protected PaymentGateway $config;
    protected string $apiKey;
    protected string $apiSecret;
    protected string $webhookSecret;

    public function __construct(PaymentGateway $config)
    {
        $this->config = $config;
        
        // Credentials are auto-decrypted by Laravel casts in the model
        $this->apiKey = $this->config->api_key_encrypted;
        $this->apiSecret = $this->config->api_secret_encrypted;
        $this->webhookSecret = $this->config->webhook_secret_encrypted ?: $this->apiSecret;
    }

    public function getProviderName(): string { return 'wish'; }

    public function createPayment(Donation $donation): string
    {
        $url = $this->config->mode === 'live' 
            ? 'https://api.wish.money/v1/checkout' 
            : 'https://sandbox.api.wish.money/v1/checkout';

        $payload = [
            'merchant_id' => $this->config->merchant_id,
            'amount' => (float)$donation->amount,
            'currency' => $donation->currency,
            'order_reference' => $donation->reference,
            'callback_url' => route('public.api.webhook.wish', ['mosque_slug' => $donation->mosque->slug]),
            'success_url' => route('public.donations.success', ['mosque_slug' => $donation->mosque->slug, 'donation' => $donation->id]),
            'cancel_url' => route('public.donations.failed', ['mosque_slug' => $donation->mosque->slug, 'donation' => $donation->id]),
            'metadata' => [
                'donor_name' => $donation->donor_name,
                'campaign_id' => $donation->campaign_id
            ]
        ];

        $response = Http::withToken($this->apiKey)->post($url, $payload);

        DonationTransaction::create([
            'mosque_id' => $donation->mosque_id,
            'donation_id' => $donation->id,
            'status' => 'initiated',
            'amount' => $donation->amount,
            'currency' => $donation->currency,
            'request_payload' => $payload,
            'response_payload' => $response->json()
        ]);

        if ($response->failed()) {
            Log::error("WISH Payment Creation Failed", ['response' => $response->body()]);
            throw new \Exception("Gateway error: " . $response->json('message', 'Unknown error'));
        }

        return $response->json('checkout_url');
    }

    public function verifyWebhook(Request $request): bool
    {
        return WishSignatureVerifier::verify($request, $this->webhookSecret);
    }
}
