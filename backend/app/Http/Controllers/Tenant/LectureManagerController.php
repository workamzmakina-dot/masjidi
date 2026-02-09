<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLectureRequest;
use App\Models\Lecture;
use App\Models\Speaker;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class LectureManagerController extends Controller
{
    public function index(): View
    {
        $lectures = Lecture::with('speaker')->latest()->paginate(20);
        return view('tenant.lectures.index', compact('lectures'));
    }

    public function create(): View
    {
        $speakers = Speaker::all();
        return view('tenant.lectures.create', compact('speakers'));
    }

    public function store(StoreLectureRequest $request): RedirectResponse
    {
        $data = $request->validated();

        if ($request->hasFile('media')) {
            $path = $request->file('media')->store('lectures', 'public');
            $data['media_path'] = $path;
        }

        Lecture::create($data);

        return redirect()->route('tenant.lectures.index', app('currentMosque')->slug)
            ->with('success', 'Lecture added successfully.');
    }
}