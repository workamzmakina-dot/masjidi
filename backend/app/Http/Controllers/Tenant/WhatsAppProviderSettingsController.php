<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppProviderSetting;
use App\Models\Mosque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class WhatsAppProviderSettingsController extends Controller
{
    public function edit()
    {
        Gate::authorize('manage-finance');
        $mosque = app(Mosque::class);
        $settings = WhatsAppProviderSetting::firstOrNew(['mosque_id' => $mosque->id]);
        return view('tenant.whatsapp.provider.edit', compact('settings', 'mosque'));
    }

    public function update(Request $request)
    {
        Gate::authorize('manage-finance');
        $mosque = app(Mosque::class);

        $request->validate([
            'provider' => 'required|in:meta,twilio,dialog360',
            'mode' => 'required|in:test,live',
            'credentials' => 'required|array',
            'is_enabled' => 'required|boolean'
        ]);

        WhatsAppProviderSetting::updateOrCreate(
            ['mosque_id' => $mosque->id],
            [
                'provider' => $request->provider,
                'mode' => $request->mode,
                'credentials_encrypted' => $request->credentials,
                'is_enabled' => $request->is_enabled
            ]
        );

        return back()->with('success', 'Provider settings updated.');
    }
}