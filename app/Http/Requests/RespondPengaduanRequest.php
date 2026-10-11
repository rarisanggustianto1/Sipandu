<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RespondPengaduanRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'status' => ['required', 'in:diproses,selesai'],
            'tanggapan_puskesmas' => ['required', 'string', 'min:10'],
        ];
    }
}
