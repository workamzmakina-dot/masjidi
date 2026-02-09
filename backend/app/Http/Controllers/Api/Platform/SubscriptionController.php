<?php

namespace App\Http\Controllers\Api\Platform;

use App\Http\Controllers\Controller;
use App\Models\MosqueSubscription;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function index()
    {
        return response()->json(MosqueSubscription::with(['mosque', 'plan'])->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'mosque_id' => ['required', 'exists:mosques,id'],
            'plan_id' => ['required', 'exists:plans,id'],
            'trial_ends_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
        ]);

        $subscription = MosqueSubscription::create($data);

        return response()->json($subscription->load(['mosque', 'plan']), 201);
    }

    public function update(Request $request, MosqueSubscription $subscription)
    {
        $data = $request->validate([
            'plan_id' => ['sometimes', 'exists:plans,id'],
            'trial_ends_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date'],
        ]);

        $subscription->update($data);

        return response()->json($subscription->load(['mosque', 'plan']));
    }
}
