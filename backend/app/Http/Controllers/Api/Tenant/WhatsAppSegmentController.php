<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppSegment;
use Illuminate\Http\Request;

class WhatsAppSegmentController extends Controller
{
    public function index()
    {
        return response()->json(WhatsAppSegment::withCount('subscribers')->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $segment = WhatsAppSegment::create($data);

        return response()->json($segment, 201);
    }

    public function show(WhatsAppSegment $segment)
    {
        return response()->json($segment->load('subscribers'));
    }

    public function update(Request $request, WhatsAppSegment $segment)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
        ]);

        $segment->update($data);

        return response()->json($segment);
    }

    public function destroy(WhatsAppSegment $segment)
    {
        $segment->delete();

        return response()->json(['message' => 'Segment deleted.']);
    }

    public function sync(Request $request, WhatsAppSegment $segment)
    {
        $data = $request->validate([
            'subscriber_ids' => ['required', 'array'],
            'subscriber_ids.*' => ['integer'],
        ]);

        $segment->subscribers()->sync($data['subscriber_ids']);

        return response()->json(['message' => 'Segment synced.']);
    }
}
