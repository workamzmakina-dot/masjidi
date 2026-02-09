<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\Donation;
use App\Models\Event;
use App\Models\WhatsAppSubscriber;

class DashboardController extends Controller
{
    public function index()
    {
        $donationTotal = Donation::where('status', 'completed')->sum('amount');
        $activeCampaigns = Campaign::where('is_active', true)->count();
        $upcomingEvents = Event::where('start_at', '>=', now())->count();
        $subscribers = WhatsAppSubscriber::where('status', 'active')->count();

        return response()->json([
            'metrics' => [
                'donation_total' => $donationTotal,
                'active_campaigns' => $activeCampaigns,
                'upcoming_events' => $upcomingEvents,
                'whatsapp_subscribers' => $subscribers,
            ],
        ]);
    }
}
