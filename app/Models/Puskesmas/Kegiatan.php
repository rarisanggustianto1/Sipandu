<?php

namespace App\Models\Puskesmas;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['posyandu_id', 'nama_kegiatan', 'jenis_kegiatan', 'deskripsi', 'tanggal_kegiatan', 'waktu_mulai', 'lokasi', 'status'])]
class Kegiatan extends Model
{
    protected $table = 'kegiatan';

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
            'waktu_mulai' => 'datetime:H:i',
        ];
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }
}