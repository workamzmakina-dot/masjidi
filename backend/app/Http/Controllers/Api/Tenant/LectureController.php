<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Lecture;
use Illuminate\Http\Request;

class LectureController extends Controller
{
    public function index()
    {
        return response()->json(Lecture::with('speaker')->latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'speaker_id' => ['required', 'integer', 'exists:speakers,id'],
            'title' => ['required', 'string'],
            'description' => ['nullable', 'string'],
            'type' => ['required', 'string'],
            'media_path' => ['nullable', 'string'],
            'external_url' => ['nullable', 'url'],
            'is_public' => ['nullable', 'boolean'],
            'recorded_at' => ['nullable', 'date'],
        ]);

        $lecture = Lecture::create($data);

        return response()->json($lecture, 201);
    }

    public function show(Lecture $lecture)
    {
        return response()->json($lecture->load('speaker'));
    }

    public function update(Request $request, Lecture $lecture)
    {
        $data = $request->validate([
            'speaker_id' => ['sometimes', 'integer', 'exists:speakers,id'],
            'title' => ['sometimes', 'string'],
            'description' => ['nullable', 'string'],
            'type' => ['sometimes', 'string'],
            'media_path' => ['nullable', 'string'],
            'external_url' => ['nullable', 'url'],
            'is_public' => ['nullable', 'boolean'],
            'recorded_at' => ['nullable', 'date'],
        ]);

        $lecture->update($data);

        return response()->json($lecture);
    }

    public function destroy(Lecture $lecture)
    {
        $lecture->delete();

        return response()->json(['message' => 'Lecture deleted.']);
    }
}
