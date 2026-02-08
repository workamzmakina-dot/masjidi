<?php

namespace App\Http\Controllers\Platform;

use App\Http\Controllers\Controller;
use App\Models\WebhookLog;
use App\Models\AuditLog;
use App\Models\Mosque;
use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function webhooks(Request $request)
    {
        $query = WebhookLog::with('mosque');

        if ($request->mosque_id) $query->where('mosque_id', $request->mosque_id);
        if ($request->provider) $query->where('provider', $request->provider);
        if ($request->status) $query->where('verified', $request->status === 'verified');

        $logs = $query->latest()->paginate(50);
        $mosques = Mosque::all();

        return view('platform.logs.webhooks', compact('logs', 'mosques'));
    }

    public function audit(Request $request)
    {
        $query = AuditLog::with('mosque');

        if ($request->mosque_id) $query->where('mosque_id', $request->mosque_id);
        if ($request->event) $query->where('event', $request->event);

        $logs = $query->latest()->paginate(50);
        $mosques = Mosque::all();

        return view('platform.logs.audit', compact('logs', 'mosques'));
    }
}
