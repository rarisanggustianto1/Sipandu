<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['puskesmas_id', 'nama_posyandu', 'alamat', 'kelurahan', 'kecamatan', 'telepon'])]
class Posyandu extends Model
{
    protected $table = 'posyandu';

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class);
    }
}
