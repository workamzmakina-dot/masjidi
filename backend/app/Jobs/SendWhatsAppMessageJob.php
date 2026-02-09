<?php

namespace App\Jobs;

use App\Models\WhatsAppMessage;
use App\Models\WhatsAppSubscriber;
use App\Services\WhatsApp\ProviderFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendWhatsAppMessageJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $tries = 3;
    public int $backoff = 60;

    public function __construct(protected int $messageId) {}

    public function handle(): void
    {
        $message = WhatsAppMessage::withoutGlobalScopes()->findOrFail($this->messageId);

        if ($message->status !== 'queued' && $message->status !== 'failed') return;

        // Safety Check: Check subscriber status before attempting send
        $subscriber = WhatsAppSubscriber::withoutGlobalScopes()
            ->where('mosque_id', $message->mosque_id)
            ->where('phone_e164', $message->to_phone_e164)
            ->first();

        if ($subscriber && in_array($subscriber->status, ['opted_out', 'blocked'])) {
            $message->update([
                'status' => 'cancelled',
                'error_message' => "Subscriber is {$subscriber->status}. Sending aborted."
            ]);
            return;
        }

        $message->update(['status' => 'sending']);

        try {
            $provider = ProviderFactory::make($message->mosque_id);
            $result = $provider->sendMessage($message->to_phone_e164, $message->body);

            if ($result['success']) {
                $message->update([
                    'status' => 'sent',
                    'sent_at' => now(),
                    'provider_message_id' => $result['provider_id']
                ]);
            } else {
                $message->update([
                    'status' => 'failed',
                    'error_message' => $result['error']
                ]);
                $this->fail($result['error']);
            }
        } catch (\Exception $e) {
            $message->update([
                'status' => 'failed',
                'error_message' => $e->getMessage()
            ]);
            throw $e;
        }
    }
}