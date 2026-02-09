
<?php

namespace App\Services\Payment;

use App\Models\Donation;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Crypt;

class WishMoneyGateway
{
    protected $config;

    public function __construct($gatewayConfig)
    {
        $this->config = Crypt::decrypt($gatewayConfig->credentials);
    }

    public function createPayment(Donation $donation)
    {
        $response = Http::withToken($this->config['api_key'])
            ->post($this->config['url'] . '/v1/pay', [
                'amount' => $donation->amount,
                'order_id' => $donation->transaction_id,
                'webhook' => route('api.webhook.wish', ['mosque_id' => $donation->mosque_id]),
                'redirect' => route('public.donations.success', ['mosque_slug' => $donation->mosque->slug])
            ]);

        return $response->json('checkout_url');
    }

    public function verifySignature($payload, $signature): bool
    {
        $expected = hash_hmac('sha256', json_encode($payload), $this->config['secret']);
        return hash_equals($expected, $signature);
    }
}
