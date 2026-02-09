<?php

namespace App\Services;

use App\Models\Donation;
use App\Models\PaymentGateway;
use GuzzleHttp\Client;

class WishMoneyService
{
    public function createPayment(Donation $donation, PaymentGateway $gateway): array
    {
        $client = new Client(['base_uri' => config('services.wish_money.base_url')]);

        $payload = [
            'merchant_id' => $gateway->merchant_id,
            'amount' => (float) $donation->amount,
            'currency' => $donation->currency,
            'reference' => $donation->reference,
            'callback_url' => str_replace('{slug}', $donation->mosque->slug, config('services.wish_money.callback_url')),
            'customer' => [
                'name' => $donation->donor_name,
                'email' => $donation->donor_email,
                'phone' => $donation->donor_phone,
            ],
        ];

        $response = $client->post('/payments', [
            'headers' => [
                'Accept' => 'application/json',
                'Authorization' => 'Bearer '.$gateway->api_key_encrypted,
            ],
            'json' => $payload,
        ]);

        $data = json_decode((string) $response->getBody(), true);

        return [
            'request' => $payload,
            'response' => $data,
            'checkout_url' => $data['checkout_url'] ?? null,
            'provider_id' => $data['id'] ?? null,
        ];
    }

    public function verifySignature(string $payload, ?string $signature, PaymentGateway $gateway): bool
    {
        if (!$gateway->webhook_secret_encrypted || !$signature) {
            return false;
        }

        $computed = hash_hmac('sha256', $payload, $gateway->webhook_secret_encrypted);

        return hash_equals($computed, $signature);
    }
}
