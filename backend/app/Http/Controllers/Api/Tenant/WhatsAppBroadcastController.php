<?php

namespace App\Http\Controllers\Api\Tenant;

use App\Http\Controllers\Controller;
use App\Jobs\SendWhatsAppMessage;
use App\Models\WhatsAppMessage;
use App\Models\WhatsAppSubscriber;
use App\Models\WhatsAppTemplate;
use Illuminate\Http\Request;

class WhatsAppBroadcastController extends Controller
{
    public function index()
    {
        return response()->json(WhatsAppMessage::latest()->paginate(25));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'template_id' => ['nullable', 'integer', 'exists:whatsapp_templates,id'],
            'body' => ['nullable', 'string'],
            'subscriber_ids' => ['nullable', 'array'],
            'subscriber_ids.*' => ['integer'],
        ]);

        $body = $data['body'] ?? null;

        if ($data['template_id']) {
            $template = WhatsAppTemplate::findOrFail($data['template_id']);
            $body = $template->content;
        }

        if (!$body) {
            return response()->json(['message' => 'Message body is required.'], 422);
        }

        $subscriberIds = $data['subscriber_ids'] ?? [];
        $subscribers = WhatsAppSubscriber::whereIn('id', $subscriberIds)->where('status', 'active')->get();

        $messages = [];

        foreach ($subscribers as $subscriber) {
            $message = WhatsAppMessage::create([
                'subscriber_id' => $subscriber->id,
                'to_phone_e164' => $subscriber->phone_e164,
                'body' => $body,
                'status' => 'queued',
                'scheduled_at' => now(),
            ]);

            SendWhatsAppMessage::dispatch($message->id);
            $messages[] = $message;
        }

        return response()->json(['messages' => $messages], 201);
    }
}
