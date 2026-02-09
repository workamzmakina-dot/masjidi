<?php

namespace App\Http\Controllers\Api\Platform;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use Illuminate\Http\Request;

class MosqueController extends Controller
{
    public function index()
    {
        return response()->json(Mosque::with('plan')->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:mosques,slug'],
            'custom_domain' => ['nullable', 'string'],
            'plan_id' => ['required', 'exists:plans,id'],
            'status' => ['required', 'in:active,suspended,trialing'],
            'settings' => ['nullable', 'array'],
        ]);

        $mosque = Mosque::create($data);

        return response()->json($mosque, 201);
    }

    public function show(Mosque $mosque)
    {
        return response()->json($mosque->load('plan'));
    }

    public function update(Request $request, Mosque $mosque)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'slug' => ['sometimes', 'string', 'unique:mosques,slug,'.$mosque->id],
            'custom_domain' => ['nullable', 'string'],
            'plan_id' => ['sometimes', 'exists:plans,id'],
            'status' => ['sometimes', 'in:active,suspended,trialing'],
            'settings' => ['nullable', 'array'],
        ]);

        $mosque->update($data);

        return response()->json($mosque);
    }

    public function destroy(Mosque $mosque)
    {
        $mosque->delete();

        return response()->json(['message' => 'Mosque deleted.']);
    }
}
