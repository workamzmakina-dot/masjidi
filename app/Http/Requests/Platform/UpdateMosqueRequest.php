<?php

namespace App\Http\Requests\Platform;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMosqueRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'custom_domain' => 'nullable|string|unique:mosques,custom_domain,' . $this->route('mosque')->id,
            'settings' => 'nullable|array'
        ];
    }
}
