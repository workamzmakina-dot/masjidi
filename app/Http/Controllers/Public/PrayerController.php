<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use App\Services\PrayerTimesService;
use Carbon\Carbon;
use Illuminate\View\View;

class PrayerController extends Controller
{
    public function index(PrayerTimesService $service): View
    {
        $mosque = app(Mosque::class);
        $today = $service->getTimesForDate($mosque, Carbon::today());
        
        $alert = $mosque->alerts()
            ->where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->first();

        $isRamadan = $mosque->settings['ramadan_mode'] ?? false;

        return view('public.prayers', compact('mosque', 'today', 'alert', 'isRamadan'));
    }
}