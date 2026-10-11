<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePosyanduRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nama_posyandu' => ['required', 'string', 'max:100'],
            'alamat' => ['required', 'string'],
            'kelurahan' => ['required', 'string'],
            'kecamatan' => ['required', 'string'],
            'telepon' => ['nullable', 'string', 'max:20'],
        ];
    }
}
