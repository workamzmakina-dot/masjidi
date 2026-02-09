<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SendBroadcastRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'target' => 'required|in:segment,direct',
            'segment_id' => 'required_if:target,segment|exists:whatsapp_segments,id',
            'direct_phone' => 'required_if:target,direct|string|min:8',
            'template_id' => 'required|exists:whatsapp_templates,id',
            'scheduled_at' => 'nullable|date|after:now',
            'variables' => 'nullable|array'
        ];
    }
}
