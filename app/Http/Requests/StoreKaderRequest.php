<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class StoreKaderRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')],
            'password' => ['required', 'confirmed', Password::min(8)],
            'posyandu_id' => [
                'required',
                // Hanya posyandu milik Puskesmas pengguna yang boleh dipilih.
                Rule::exists('posyandu', 'id')->where(
                    'puskesmas_id',
                    $this->user()?->puskesmas_id
                ),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'posyandu_id.exists' => 'Posyandu yang dipilih tidak terdaftar pada Puskesmas Anda.',
        ];
    }
}