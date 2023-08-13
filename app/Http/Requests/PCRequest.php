<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PCRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required'],
            'url' => ['required', 'url'],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
