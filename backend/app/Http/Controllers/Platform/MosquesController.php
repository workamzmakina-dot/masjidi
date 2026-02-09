<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Http\Requests\Platform\StoreMosqueRequest;
use App\Http\Requests\Platform\UpdateMosqueRequest;
use App\Models\Mosque;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MosquesController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Mosque::with('plan');

        if ($user->isReseller()) {
            $query->where('created_by_user_id', $user->id);
        }

        if ($request->status) $query->where('status', $request->status);
        if ($request->plan_id) $query->where('plan_id', $request->plan_id);
        if ($request->search) {
            $query->where(fn($q) => $q->where('name', 'like', "%{$request->search}%")->orWhere('slug', 'like', "%{$request->search}%"));
        }

        $mosques = $query->latest()->paginate(20);
        $plans = Plan::all();

        return view('platform.mosques.index', compact('mosques', 'plans'));
    }

    public function create()
    {
        $plans = Plan::all();
        return view('platform.mosques.create', compact('plans'));
    }

    public function store(StoreMosqueRequest $request)
    {
        $mosque = Mosque::create(array_merge($request->validated(), [
            'created_by_user_id' => Auth::id(),
            'status' => 'trialing'
        ]));

        return redirect()->route('platform.mosques.show', $mosque)
            ->with('success', 'Mosque tenant created successfully.');
    }

    public function show(Mosque $mosque)
    {
        if (Auth::user()->isReseller() && $mosque->created_by_user_id !== Auth::id()) {
            abort(403);
        }

        $mosque->load('plan');
        return view('platform.mosques.show', compact('mosque'));
    }

    public function edit(Mosque $mosque)
    {
        if (Auth::user()->isReseller() && $mosque->created_by_user_id !== Auth::id()) {
            abort(403);
        }

        $plans = Plan::all();
        return view('platform.mosques.edit', compact('mosque', 'plans'));
    }

    public function update(UpdateMosqueRequest $request, Mosque $mosque)
    {
        if (Auth::user()->isReseller() && $mosque->created_by_user_id !== Auth::id()) {
            abort(403);
        }

        $mosque->update($request->validated());
        return redirect()->route('platform.mosques.show', $mosque)->with('success', 'Settings updated.');
    }

    public function suspend(Mosque $mosque)
    {
        $mosque->update(['status' => 'suspended']);
        return back()->with('success', 'Mosque suspended.');
    }

    public function activate(Mosque $mosque)
    {
        $mosque->update(['status' => 'active']);
        return back()->with('success', 'Mosque activated.');
    }
}
