<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Http\Requests\Platform\StorePlanRequest;
use App\Http\Requests\Platform\UpdatePlanRequest;
use App\Models\Plan;

class PlansController extends Controller
{
    public function index()
    {
        $plans = Plan::all();
        return view('platform.plans.index', compact('plans'));
    }

    public function create()
    {
        return view('platform.plans.create');
    }

    public function store(StorePlanRequest $request)
    {
        Plan::create($request->validated());
        return redirect()->route('platform.plans.index')->with('success', 'Plan created.');
    }

    public function edit(Plan $plan)
    {
        return view('platform.plans.edit', compact('plan'));
    }

    public function update(UpdatePlanRequest $request, Plan $plan)
    {
        $plan->update($request->validated());
        return redirect()->route('platform.plans.index')->with('success', 'Plan updated.');
    }
}
