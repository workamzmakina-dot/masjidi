<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index()
    {
        return response()->json(Event::orderByDesc('start_at')->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'location' => ['nullable', 'string'],
            'start_at' => ['required', 'date'],
            'end_at' => ['nullable', 'date'],
            'recurrence' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string'],
        ]);

        $event = Event::create($data);

        return response()->json($event, 201);
    }

    public function show(Event $event)
    {
        return response()->json($event);
    }

    public function update(Request $request, Event $event)
    {
        $data = $request->validate([
            'title' => ['sometimes', 'string'],
            'description' => ['sometimes', 'string'],
            'location' => ['nullable', 'string'],
            'start_at' => ['sometimes', 'date'],
            'end_at' => ['nullable', 'date'],
            'recurrence' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string'],
        ]);

        $event->update($data);

        return response()->json($event);
    }

    public function destroy(Event $event)
    {
        $event->delete();

        return response()->json(['message' => 'Event deleted.']);
    }
}
