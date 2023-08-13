<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'string', 'email', 'max:254', 'unique:users'],
            'password' => ['required', 'string', Password::default()],
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
