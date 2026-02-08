<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use App\Services\Payment\WishMoneyGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaymentWebhookController extends Controller
{
    public function handleWish(Request $request)
    {
        $signature = $request->header('X-Wish-Signature');
        $payload = $request->all();

        // In a real app, we fetch the specific gateway config for the mosque_id in payload
        $gateway = new WishMoneyGateway((object)[
            'credentials' => encrypt([
                'api_key' => config('services.wish.key'),
                'secret' => config('services.wish.secret'),
                'url' => 'https://api.wish.money'
            ])
        ]);

        if (!$gateway->verifySignature($payload, $signature)) {
            Log::error('Invalid WishMoney Signature', ['payload' => $payload]);
            return response()->json(['error' => 'Invalid signature'], 403);
        }

        $donation = Donation::where('transaction_id', $payload['order_id'])->first();

        if ($donation && $payload['status'] === 'success') {
            $donation->update(['status' => 'completed']);
            // Trigger receipt generation or WhatsApp notification here
        }

        return response()->json(['status' => 'ok']);
    }
}
