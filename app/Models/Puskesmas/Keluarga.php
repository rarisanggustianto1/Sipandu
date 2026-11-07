<?php

namespace App\Models\Puskesmas;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['posyandu_id', 'no_kk', 'nama_kepala_keluarga', 'alamat', 'no_telepon'])]
class Keluarga extends Model
{
    protected $table = 'keluarga';

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function pesertas()
    {
        return $this->hasMany(Peserta::class);
    }
}