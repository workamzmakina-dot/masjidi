<?php

namespace App\Http\Requests;

use App\Services\WhatsApp\PhoneNormalizer;
use Illuminate\Foundation\Http\FormRequest;

class PublicSubscribeWhatsAppRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => 'nullable|string|max:100',
            'phone' => 'required|string|min:8|max:20',
            'consent' => 'required|accepted',
            'locale' => 'required|in:ar,en',
        ];
    }

    protected function passedValidation(): void
    {
        $this->merge([
            'phone_e164' => PhoneNormalizer::normalize($this->phone)
        ]);
    }
}
