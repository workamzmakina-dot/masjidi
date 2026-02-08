<?php

namespace App\Http\Controllers\Tenant;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendBroadcastRequest;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppTemplate;
use App\Models\WhatsAppSegment;
use App\Models\Mosque;
use App\Jobs\EnqueueBroadcastJob;
use App\Jobs\SendWhatsAppMessageJob;
use App\Services\WhatsApp\TemplateRenderer;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class WhatsAppBroadcastController extends Controller
{
    public function index(): View
    {
        $messages = WhatsAppMessage::with('subscriber', 'template')
            ->latest()
            ->paginate(20);
            
        return view('tenant.whatsapp.outbox.index', compact('messages'));
    }

    public function create(): View
    {
        Gate::authorize('manage-finance');

        $segments = WhatsAppSegment::all();
        $templates = WhatsAppTemplate::where('is_enabled', true)->get();
        return view('tenant.whatsapp.broadcast.create', compact('segments', 'templates'));
    }

    public function store(SendBroadcastRequest $request)
    {
        Gate::authorize('manage-finance');

        $mosque = app(Mosque::class);
        $template = WhatsAppTemplate::findOrFail($request->template_id);
        
        $variables = $request->variables ?? [];
        $variables['unsubscribe_url'] = route('public.whatsapp.unsubscribe', $mosque->slug);

        if ($request->target === 'segment') {
            EnqueueBroadcastJob::dispatch(
                $mosque->id,
                $request->segment_id,
                $template->key,
                $variables
            );
            return redirect()->route('tenant.whatsapp.outbox.index', $mosque->slug)
                ->with('success', 'Broadcast queued successfully.');
        }

        $phone = \App\Services\WhatsApp\PhoneNormalizer::normalize($request->direct_phone);
        $renderer = new TemplateRenderer();
        $body = $renderer->render($template->content, $variables, $mosque);

        $msg = WhatsAppMessage::create([
            'mosque_id' => $mosque->id,
            'to_phone_e164' => $phone,
            'body' => $body,
            'template_id' => $template->id,
            'status' => 'queued',
            'scheduled_at' => $request->scheduled_at
        ]);

        if (!$request->scheduled_at) {
            SendWhatsAppMessageJob::dispatch($msg->id);
        }

        return redirect()->route('tenant.whatsapp.outbox.index', $mosque->slug)
            ->with('success', 'Message processed.');
    }
}