<?php

namespace App\Models\Puskesmas;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['keluarga_id', 'nik', 'nama', 'jenis_kelamin', 'tanggal_lahir', 'kategori'])]
class Peserta extends Model
{
    protected $table = 'peserta';

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function pemeriksaans()
    {
        return $this->hasMany(Pemeriksaan::class);
    }
}