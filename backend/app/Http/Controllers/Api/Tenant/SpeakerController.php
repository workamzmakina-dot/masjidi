<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Speaker;
use Illuminate\Http\Request;

class SpeakerController extends Controller
{
    public function index()
    {
        return response()->json(Speaker::latest()->paginate(20));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required', 'string'],
            'title' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string'],
        ]);

        $speaker = Speaker::create($data);

        return response()->json($speaker, 201);
    }

    public function show(Speaker $speaker)
    {
        return response()->json($speaker);
    }

    public function update(Request $request, Speaker $speaker)
    {
        $data = $request->validate([
            'name' => ['sometimes', 'string'],
            'title' => ['nullable', 'string'],
            'bio' => ['nullable', 'string'],
            'image_path' => ['nullable', 'string'],
        ]);

        $speaker->update($data);

        return response()->json($speaker);
    }

    public function destroy(Speaker $speaker)
    {
        $speaker->delete();

        return response()->json(['message' => 'Speaker deleted.']);
    }
}
