<?php

namespace App\Http\Controllers\Api\Platform;

use App\Http\Controllers\Controller;
use App\Models\MosqueFeatureOverride;
use Illuminate\Http\Request;

class FeatureOverrideController extends Controller
{
    public function index()
    {
        return response()->json(MosqueFeatureOverride::with(['mosque', 'feature'])->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mosque_id' => ['required', 'exists:mosques,id'],
            'feature_id' => ['required', 'exists:features,id'],
            'enabled' => ['required', 'boolean'],
            'custom_limits' => ['nullable', 'array'],
        ]);

        $override = MosqueFeatureOverride::create($data);

        return response()->json($override->load(['mosque', 'feature']), 201);
    }

    public function update(Request $request, MosqueFeatureOverride $override)
    {
        $data = $request->validate([
            'enabled' => ['nullable', 'boolean'],
            'custom_limits' => ['nullable', 'array'],
        ]);

        $override->update($data);

        return response()->json($override->load(['mosque', 'feature']));
    }
}
