<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use Illuminate\Http\Request;

class AlertController extends Controller
{
    public function index()
    {
        return response()->json(Alert::latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'message' => ['required', 'string'],
            'type' => ['required', 'in:info,warning,emergency'],
            'starts_at' => ['required', 'date'],
            'ends_at' => ['required', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $alert = Alert::create($data);

        return response()->json($alert, 201);
    }

    public function show(Alert $alert)
    {
        return response()->json($alert);
    }

    public function update(Request $request, Alert $alert)
    {
        $data = $request->validate([
            'message' => ['sometimes', 'string'],
            'type' => ['sometimes', 'in:info,warning,emergency'],
            'starts_at' => ['sometimes', 'date'],
            'ends_at' => ['sometimes', 'date'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $alert->update($data);

        return response()->json($alert);
    }

    public function destroy(Alert $alert)
    {
        $alert->delete();

        return response()->json(['message' => 'Alert deleted.']);
    }
}
