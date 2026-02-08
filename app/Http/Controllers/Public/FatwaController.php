<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFatwaRequest;
use App\Models\Mosque;
use App\Models\FatwaQuestion;
use App\Models\FatwaCategory;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class FatwaController extends Controller
{
    public function index(): View
    {
        $mosque = app(Mosque::class);
        $categories = FatwaCategory::all();
        $questions = FatwaQuestion::where('is_public', true)
            ->where('status', 'published')
            ->latest()
            ->paginate(15);

        return view('public.fatwas', compact('mosque', 'categories', 'questions'));
    }

    public function store(StoreFatwaRequest $request): RedirectResponse
    {
        $mosque = app(Mosque::class);
        
        FatwaQuestion::create($request->validated());

        return back()->with('success', 'Your question has been submitted to the Imam. We will notify you once answered.');
    }
}