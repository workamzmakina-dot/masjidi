<?php

namespace App\Services\WhatsApp;

class PhoneNormalizer
{
    /**
     * Normalize phone number to E.164.
     * Assumes a default country code if missing, but strictly expects digits.
     */
    public static function normalize(string $phone, string $defaultCountry = '961'): string
    {
        // Remove non-digits
        $cleaned = preg_replace('/\D/', '', $phone);

        if (str_starts_with($cleaned, '00')) {
            $cleaned = substr($cleaned, 2);
        }

        // If it starts with 0 and is likely a local number
        if (str_starts_with($cleaned, '0') && strlen($cleaned) <= 10) {
            $cleaned = $defaultCountry . substr($cleaned, 1);
        }

        // If no country code prefix found (short number), prepend default
        if (strlen($cleaned) < 10) {
            $cleaned = $defaultCountry . $cleaned;
        }

        return '+' . $cleaned;
    }
}
