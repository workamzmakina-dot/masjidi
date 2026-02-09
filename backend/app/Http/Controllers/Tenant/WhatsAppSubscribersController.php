<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\ImportSubscribersCsvRequest;
use App\Models\WhatsAppSubscriber;
use App\Models\WhatsAppConsentLog;
use App\Models\Mosque;
use App\Services\WhatsApp\PhoneNormalizer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class WhatsAppSubscribersController extends Controller
{
    public function index(Request $request)
    {
        $query = WhatsAppSubscriber::query();
        if ($request->search) {
            $query->where('name', 'like', "%{$request->search}%")
                  ->orWhere('phone_e164', 'like', "%{$request->search}%");
        }
        if ($request->status) $query->where('status', $request->status);

        $subscribers = $query->latest()->paginate(25);
        $mosque = app(Mosque::class);

        return view('tenant.whatsapp.subscribers.index', compact('subscribers', 'mosque'));
    }

    public function import(ImportSubscribersCsvRequest $request)
    {
        Gate::authorize('manage-content');
        $mosque = app(Mosque::class);
        $file = $request->file('file');
        $handle = fopen($file->getRealPath(), 'r');
        
        $stats = ['imported' => 0, 'skipped' => 0, 'duplicates' => 0];
        $maxRows = 5000;
        $rowCount = 0;

        DB::transaction(function() use ($handle, $mosque, &$stats, &$rowCount, $maxRows) {
            fgetcsv($handle); // Skip header

            while (($row = fgetcsv($handle)) !== false && $rowCount < $maxRows) {
                $rowCount++;
                $phone = $row[1] ?? null;
                $name = $row[0] ?? null;

                if (!$phone) {
                    $stats['skipped']++;
                    continue;
                }

                $phoneE164 = PhoneNormalizer::normalize($phone);

                $exists = WhatsAppSubscriber::where('mosque_id', $mosque->id)
                    ->where('phone_e164', $phoneE164)
                    ->exists();

                if ($exists) {
                    $stats['duplicates']++;
                    continue;
                }

                $sub = WhatsAppSubscriber::create([
                    'mosque_id' => $mosque->id,
                    'name' => $name,
                    'phone_e164' => $phoneE164,
                    'status' => 'active',
                    'source' => 'admin_import'
                ]);

                WhatsAppConsentLog::create([
                    'mosque_id' => $mosque->id,
                    'subscriber_id' => $sub->id,
                    'action' => 'opt_in',
                    'channel' => 'admin_import',
                    'occurred_at' => now(),
                ]);

                $stats['imported']++;
            }
        });

        fclose($handle);

        return back()->with('success', "Import finished: {$stats['imported']} imported, {$stats['duplicates']} duplicates, {$stats['skipped']} invalid.");
    }

    public function block(Mosque $mosque, WhatsAppSubscriber $subscriber)
    {
        Gate::authorize('manage-content');
        $subscriber->update(['status' => 'blocked']);
        return back()->with('success', 'Subscriber blocked.');
    }

    public function unblock(Mosque $mosque, WhatsAppSubscriber $subscriber)
    {
        Gate::authorize('manage-content');
        $subscriber->update(['status' => 'active']);
        return back()->with('success', 'Subscriber unblocked.');
    }
}