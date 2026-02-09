<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use Illuminate\View\View;

class MosqueHomeController extends Controller
{
    public function index(): View
    {
        $mosque = app(Mosque::class);
        return view('public.home', compact('mosque'));
    }

    public function prayerTimes(): View
    {
        $mosque = app(Mosque::class);
        return view('public.prayer-times', compact('mosque'));
    }
}