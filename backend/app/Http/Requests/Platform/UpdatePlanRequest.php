<?php

namespace App\Http\Requests\Platform;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePlanRequest extends FormRequest
{
    public function authorize(): bool { return auth()->user()->isSuperAdmin(); }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:100',
            'price_monthly' => 'required|numeric|min:0',
            'limits' => 'required|array',
            'features' => 'required|array'
        ];
    }
}
