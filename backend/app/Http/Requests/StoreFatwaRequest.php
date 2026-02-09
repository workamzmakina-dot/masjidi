<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFatwaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:fatwa_categories,id',
            'user_name' => 'nullable|string|max:100',
            'user_contact' => 'nullable|string|max:100',
            'question' => 'required|string|min:10|max:5000',
            'is_public' => 'required|boolean',
        ];
    }
}