<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppSubscriber;
use Illuminate\Http\Request;

class WhatsAppPublicController extends Controller
{
    public function subscribe(Request $request)
    {
        $data = $request->validate([
            'phone_e164' => ['required', 'string'],
            'name' => ['nullable', 'string'],
            'locale' => ['nullable', 'string', 'max:5'],
        ]);

        $subscriber = WhatsAppSubscriber::updateOrCreate(
            ['phone_e164' => $data['phone_e164']],
            [
                'name' => $data['name'] ?? null,
                'locale' => $data['locale'] ?? 'ar',
                'status' => 'active',
                'source' => 'website',
                'last_opt_in_at' => now(),
            ]
        );

        return response()->json(['subscriber' => $subscriber], 201);
    }

    public function unsubscribe(Request $request)
    {
        $data = $request->validate([
            'phone_e164' => ['required', 'string'],
        ]);

        $subscriber = WhatsAppSubscriber::where('phone_e164', $data['phone_e164'])->first();

        if ($subscriber) {
            $subscriber->update([
                'status' => 'opted_out',
                'last_opt_out_at' => now(),
            ]);
        }

        return response()->json(['message' => 'Unsubscribed successfully.']);
    }
}
