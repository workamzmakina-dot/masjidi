<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\PrayerSetting;
use Illuminate\Http\Request;

class PrayerSettingsController extends Controller
{
    public function show()
    {
        $settings = PrayerSetting::first();

        return response()->json(['settings' => $settings]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'method' => ['required', 'string'],
            'timezone' => ['required', 'string'],
            'latitude' => ['nullable', 'numeric'],
            'longitude' => ['nullable', 'numeric'],
            'manual_adjustments' => ['nullable', 'array'],
            'iqama_offsets' => ['nullable', 'array'],
            'use_iqama_static_times' => ['nullable', 'boolean'],
            'iqama_static_times' => ['nullable', 'array'],
        ]);

        $settings = PrayerSetting::first();

        if ($settings) {
            $settings->update($data);
        } else {
            $settings = PrayerSetting::create($data);
        }

        return response()->json(['settings' => $settings]);
    }
}
