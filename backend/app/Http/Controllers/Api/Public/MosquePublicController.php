<?php

namespace App\Http\Controllers\Api\Public;

use App\Http\Controllers\Controller;
use App\Models\Alert;
use App\Models\Announcement;
use App\Models\Event;
use App\Models\FatwaQuestion;
use App\Models\Lecture;
use App\Models\Mosque;
use App\Models\PrayerSetting;
use App\Models\Campaign;

class MosquePublicController extends Controller
{
    protected function mosque(): Mosque
    {
        return app(Mosque::class);
    }

    public function show()
    {
        $mosque = $this->mosque();

        return response()->json([
            'mosque' => $mosque->only(['id', 'name', 'slug', 'custom_domain', 'settings', 'status'])
        ]);
    }

    public function prayers()
    {
        $settings = PrayerSetting::first();

        return response()->json([
            'settings' => $settings
        ]);
    }

    public function lectures()
    {
        $lectures = Lecture::with('speaker')->latest()->paginate(15);

        return response()->json($lectures);
    }

    public function events()
    {
        $events = Event::orderBy('start_at')->paginate(15);

        return response()->json($events);
    }

    public function campaigns()
    {
        $campaigns = Campaign::where('is_active', true)->orderByDesc('created_at')->paginate(12);

        return response()->json($campaigns);
    }

    public function alerts()
    {
        $alerts = Alert::where('is_active', true)
            ->where('starts_at', '<=', now())
            ->where('ends_at', '>=', now())
            ->get();

        return response()->json(['alerts' => $alerts]);
    }

    public function announcements()
    {
        $announcements = Announcement::where('is_active', true)
            ->orderByDesc('created_at')
            ->get();

        return response()->json(['announcements' => $announcements]);
    }

    public function fatwas()
    {
        $fatwas = FatwaQuestion::where('status', 'published')
            ->where('is_public', true)
            ->with('category')
            ->latest()
            ->paginate(10);

        return response()->json($fatwas);
    }
}
