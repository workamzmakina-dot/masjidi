<?php

namespace App\Jobs;

use App\Models\WhatsAppMessage;
use App\Models\WhatsAppProvider;
use App\Models\WhatsAppDeliveryLog;
use GuzzleHttp\Client;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendWhatsAppMessage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public int $messageId)
    {
    }

    public function handle(): void
    {
        $message = WhatsAppMessage::find($this->messageId);

        if (!$message) {
            return;
        }

        $provider = WhatsAppProvider::where('is_active', true)->first();

        if (!$provider) {
            $message->update(['status' => 'failed', 'error_message' => 'No active provider.']);
            return;
        }

        $client = new Client(['base_uri' => $provider->api_url]);

        $payload = [
            'to' => $message->to_phone_e164,
            'message' => $message->body,
            'sender' => $provider->sender_name,
        ];

        try {
            $response = $client->post('/messages', [
                'headers' => [
                    'Authorization' => 'Bearer '.$provider->api_token,
                    'Accept' => 'application/json',
                ],
                'json' => $payload,
            ]);

            $responseBody = json_decode((string) $response->getBody(), true);

            $message->update([
                'status' => 'sent',
                'sent_at' => now(),
                'provider_name' => $provider->provider,
                'provider_message_id' => $responseBody['id'] ?? null,
                'metadata' => $responseBody,
            ]);

            WhatsAppDeliveryLog::create([
                'message_id' => $message->id,
                'provider_event' => 'sent',
                'provider_payload' => $responseBody,
                'occurred_at' => now(),
            ]);
        } catch (\Throwable $exception) {
            $message->update([
                'status' => 'failed',
                'error_message' => $exception->getMessage(),
            ]);

            WhatsAppDeliveryLog::create([
                'message_id' => $message->id,
                'provider_event' => 'failed',
                'provider_payload' => ['error' => $exception->getMessage()],
                'occurred_at' => now(),
            ]);
        }
    }
}
