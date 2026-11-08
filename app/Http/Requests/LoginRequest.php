<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'login' => ['nullable', 'required_without:email', 'string'],
            'email' => ['nullable', 'required_without:login', 'string'],
            'password' => ['required', 'string'],
        ];
    }
}
