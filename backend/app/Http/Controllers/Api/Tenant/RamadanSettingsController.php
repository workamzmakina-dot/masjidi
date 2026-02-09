<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\RamadanSetting;
use Illuminate\Http\Request;

class RamadanSettingsController extends Controller
{
    public function show()
    {
        return response()->json(['settings' => RamadanSetting::first()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'taraweeh_enabled' => ['nullable', 'boolean'],
            'iftar_time' => ['nullable', 'date_format:H:i'],
            'suhoor_time' => ['nullable', 'date_format:H:i'],
            'announcements' => ['nullable', 'array'],
        ]);

        $settings = RamadanSetting::first();

        if ($settings) {
            $settings->update($data);
        } else {
            $settings = RamadanSetting::create($data);
        }

        return response()->json(['settings' => $settings]);
    }
}
