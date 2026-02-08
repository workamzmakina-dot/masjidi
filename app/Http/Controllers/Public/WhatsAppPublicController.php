<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicSubscribeWhatsAppRequest;
use App\Models\WhatsAppSubscriber;
use App\Models\WhatsAppConsentLog;
use App\Models\Mosque;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WhatsAppPublicController extends Controller
{
    public function showSubscribe()
    {
        $mosque = app(Mosque::class);
        return view('public.whatsapp.subscribe', compact('mosque'));
    }

    public function processSubscribe(PublicSubscribeWhatsAppRequest $request)
    {
        $mosque = app(Mosque::class);

        DB::transaction(function() use ($request, $mosque) {
            $subscriber = WhatsAppSubscriber::updateOrCreate(
                ['mosque_id' => $mosque->id, 'phone_e164' => $request->phone_e164],
                [
                    'name' => $request->name,
                    'locale' => $request->locale,
                    'status' => 'active',
                    'source' => 'website',
                    'last_opt_in_at' => now()
                ]
            );

            WhatsAppConsentLog::create([
                'mosque_id' => $mosque->id,
                'subscriber_id' => $subscriber->id,
                'action' => 'opt_in',
                'channel' => 'website',
                'ip_hash' => hash('sha256', $request->ip()),
                'user_agent' => $request->userAgent(),
                'occurred_at' => now(),
            ]);
        });

        return redirect()->route('public.whatsapp.subscribed', $mosque->slug);
    }

    public function subscribed()
    {
        return view('public.whatsapp.subscribed', ['mosque' => app(Mosque::class)]);
    }

    public function showUnsubscribe()
    {
        return view('public.whatsapp.unsubscribe', ['mosque' => app(Mosque::class)]);
    }

    public function processUnsubscribe(Request $request)
    {
        $request->validate(['phone' => 'required']);
        $mosque = app(Mosque::class);
        $phoneE164 = \App\Services\WhatsApp\PhoneNormalizer::normalize($request->phone);

        $subscriber = WhatsAppSubscriber::where('phone_e164', $phoneE164)->first();

        if ($subscriber) {
            DB::transaction(function() use ($subscriber, $mosque, $request) {
                $subscriber->update([
                    'status' => 'opted_out',
                    'last_opt_out_at' => now()
                ]);

                WhatsAppConsentLog::create([
                    'mosque_id' => $mosque->id,
                    'subscriber_id' => $subscriber->id,
                    'action' => 'opt_out',
                    'channel' => 'website',
                    'ip_hash' => hash('sha256', $request->ip()),
                    'user_agent' => $request->userAgent(),
                    'occurred_at' => now(),
                ]);
            });
        }

        return redirect()->route('public.whatsapp.unsubscribed', $mosque->slug);
    }

    public function unsubscribed()
    {
        return view('public.whatsapp.unsubscribed', ['mosque' => app(Mosque::class)]);
    }
}
