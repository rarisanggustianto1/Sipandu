<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterUserRequest extends FormRequest
{
    public function rules(): array
    {
        // Pendaftaran tiap role berbeda-beda.
        // Untuk sekarang: user posyandu (kader) yang didaftarkan oleh Dinas Kesehatan.
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:kader'],
        ];

        // Field khusus kader: wajib terdaftar pada sebuah posyandu.
        if ($this->input('role') === 'kader') {
            $rules['posyandu_id'] = ['required', 'exists:posyandu,id'];
        }

        return $rules;
    }
}
