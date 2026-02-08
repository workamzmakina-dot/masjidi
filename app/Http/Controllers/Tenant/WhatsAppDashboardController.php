<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Models\WhatsAppSubscriber;
use App\Models\WhatsAppMessage;
use App\Models\UsageCounter;
use App\Models\Mosque;
use Illuminate\View\View;

class WhatsAppDashboardController extends Controller
{
    public function index(): View
    {
        $mosque = app(Mosque::class);
        
        $stats = [
            'active_subscribers' => WhatsAppSubscriber::where('status', 'active')->count(),
            'opted_out' => WhatsAppSubscriber::where('status', 'opted_out')->count(),
            'sent_this_month' => UsageCounter::where('mosque_id', $mosque->id)
                ->where('feature_name', 'whatsapp_sent')
                ->where('reset_date', '>=', now()->startOfMonth())
                ->value('current_usage') ?? 0,
            'failed_count' => WhatsAppMessage::where('status', 'failed')->where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        $limit = $mosque->plan->limits['whatsapp_messages'] ?? 0;
        $stats['quota_remaining'] = max(0, $limit - $stats['sent_this_month']);
        $stats['quota_percent'] = $limit > 0 ? min(100, round(($stats['sent_this_month'] / $limit) * 100)) : 0;

        return view('tenant.whatsapp.dashboard', compact('mosque', 'stats'));
    }
}
