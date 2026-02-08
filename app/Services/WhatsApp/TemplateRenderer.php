<?php

namespace App\Services\WhatsApp;

use App\Models\Mosque;

class TemplateRenderer
{
    protected array $allowedVariables = [
        'mosque_name', 'mosque_url', 'campaign_title', 'campaign_url', 
        'lecture_title', 'lecture_url', 'event_title', 'event_date', 
        'alert_message', 'unsubscribe_url'
    ];

    public function render(string $template, array $data, ?Mosque $mosque = null): string
    {
        $rendered = $template;

        // Ensure unsubscribe_url is always provided
        if ($mosque && !isset($data['unsubscribe_url'])) {
            $data['unsubscribe_url'] = route('public.whatsapp.unsubscribe', $mosque->slug);
        }

        foreach ($data as $key => $value) {
            if (in_array($key, $this->allowedVariables)) {
                $rendered = str_replace('{{' . $key . '}}', (string)$value, $rendered);
            }
        }

        // Compliance: Force unsubscribe link if missing in the rendered body
        if (isset($data['unsubscribe_url']) && !str_contains($rendered, $data['unsubscribe_url'])) {
            $rendered .= "\n\n---\nTo stop: " . $data['unsubscribe_url'];
        }

        return $rendered;
    }
}