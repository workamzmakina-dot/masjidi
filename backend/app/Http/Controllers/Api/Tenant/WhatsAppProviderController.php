<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppProvider;
use Illuminate\Http\Request;

class WhatsAppProviderController extends Controller
{
    public function show()
    {
        $provider = WhatsAppProvider::first();

        return response()->json(['provider' => $provider]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'provider' => ['required', 'string'],
            'api_url' => ['required', 'url'],
            'api_token' => ['required', 'string'],
            'sender_name' => ['nullable', 'string'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $provider = WhatsAppProvider::first();

        if ($provider) {
            $provider->update($data);
        } else {
            $provider = WhatsAppProvider::create($data);
        }

        return response()->json(['provider' => $provider]);
    }
}
