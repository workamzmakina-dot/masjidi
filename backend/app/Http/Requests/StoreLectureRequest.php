<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLectureRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Step 2 middleware handles mosque_id auth
    }

    public function rules(): array
    {
        return [
            'speaker_id' => 'required|exists:speakers,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|in:video,audio,pdf,link',
            'media' => 'nullable|file|mimes:mp3,mp4,pdf|max:51200', // 50MB
            'external_url' => 'nullable|url',
            'is_public' => 'required|boolean',
            'recorded_at' => 'nullable|date',
        ];
    }
}