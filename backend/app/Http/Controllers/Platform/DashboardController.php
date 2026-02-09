<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use App\Models\UsageCounter;
use App\Models\Donation;
use App\Models\WhatsAppSubscriber;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = Auth::user();
        
        $baseQuery = Mosque::query();
        if ($user->isReseller()) {
            $baseQuery->where('created_by_user_id', $user->id);
        }

        $stats = [
            'total_mosques' => (clone $baseQuery)->count(),
            'active_mosques' => (clone $baseQuery)->where('status', 'active')->count(),
            'total_subscribers' => WhatsAppSubscriber::count(),
            'whatsapp_sent_month' => UsageCounter::where('feature_name', 'whatsapp_sent')
                ->where('reset_date', '>=', now()->startOfMonth())
                ->sum('current_usage'),
            'total_donations' => Donation::count(),
        ];

        $recentMosques = (clone $baseQuery)->with('plan')->latest()->take(5)->get();

        return view('platform.dashboard', compact('stats', 'recentMosques'));
    }
}
