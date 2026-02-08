<?php

namespace App\Http\Requests\Platform;

use Illuminate\Foundation\Http\FormRequest;

class StoreMosqueRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'slug' => 'required|string|alpha_dash|unique:mosques,slug',
            'plan_id' => 'required|exists:plans,id',
            'settings' => 'nullable|array'
        ];
    }
}
