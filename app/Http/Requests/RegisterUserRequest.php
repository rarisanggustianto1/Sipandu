<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:kader'],
        ];

        if ($this->input('role') === 'kader') {
            $rules['posyandu_id'] = [
                'required',
                Rule::exists('posyandu', 'id')
                    ->where('puskesmas_id', auth()->user()->puskesmas_id),
            ];
        }

        return $rules;
    }
}
