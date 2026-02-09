<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\WhiteLabelBranding;
use Illuminate\Http\Request;

class BrandingController extends Controller
{
    public function show()
    {
        return response()->json(['branding' => WhiteLabelBranding::first()]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'logo_path' => ['nullable', 'string'],
            'primary_color' => ['nullable', 'string'],
            'secondary_color' => ['nullable', 'string'],
            'font_family' => ['nullable', 'string'],
            'custom_domain' => ['nullable', 'string'],
        ]);

        $branding = WhiteLabelBranding::first();

        if ($branding) {
            $branding->update($data);
        } else {
            $branding = WhiteLabelBranding::create($data);
        }

        return response()->json(['branding' => $branding]);
    }
}
