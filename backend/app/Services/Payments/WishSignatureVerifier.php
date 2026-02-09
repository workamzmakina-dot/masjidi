<?php

namespace App\Services\Payments;

use Illuminate\Http\Request;

class WishSignatureVerifier
{
    /**
     * Verify WISH Money webhook signature.
     */
    public static function verify(Request $request, string $secret): bool
    {
        $signature = $request->header('X-Wish-Signature');
        $timestamp = $request->header('X-Wish-Timestamp');
        
        if (!$signature || !$timestamp) {
            return false;
        }

        // Anti-replay: 5 minute window
        if (abs(time() - (int)$timestamp) > 300) {
            return false;
        }

        $payload = $timestamp . '.' . $request->getContent();
        $expected = hash_hmac('sha256', $payload, $secret);

        return hash_equals($expected, $signature);
    }
}
