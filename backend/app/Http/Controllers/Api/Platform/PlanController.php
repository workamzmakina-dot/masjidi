<?php

namespace App\Http\Controllers\Api\Platform;

use App\Http\Controllers\Controller;
use App\Models\Feature;
use App\Models\Plan;
use Illuminate\Http\Request;

class PlanController extends Controller
{
    public function index()
    {
        return response()->json(Plan::with('features')->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:plans,slug'],
            'price_monthly' => ['required', 'numeric'],
            'limits' => ['nullable', 'array'],
            'feature_ids' => ['nullable', 'array'],
            'feature_ids.*' => ['integer', 'exists:features,id'],
        ]);

        $plan = Plan::create($data);

        if (!empty($data['feature_ids'])) {
            $plan->features()->sync($data['feature_ids']);
        }

        return response()->json($plan->load('features'), 201);
    }

    public function show(Plan $plan)
    {
        return response()->json($plan->load('features'));
    }

    public function update(Request $request, Plan $plan)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'slug' => ['sometimes', 'string', 'unique:plans,slug,'.$plan->id],
            'price_monthly' => ['sometimes', 'numeric'],
            'limits' => ['nullable', 'array'],
            'feature_ids' => ['nullable', 'array'],
            'feature_ids.*' => ['integer', 'exists:features,id'],
        ]);

        $plan->update($data);

        if (array_key_exists('feature_ids', $data)) {
            $plan->features()->sync($data['feature_ids'] ?? []);
        }

        return response()->json($plan->load('features'));
    }

    public function destroy(Plan $plan)
    {
        $plan->delete();

        return response()->json(['message' => 'Plan deleted.']);
    }
}
