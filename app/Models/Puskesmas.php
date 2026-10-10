<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['dinas_kesehatan_id', 'nama_puskesmas', 'alamat', 'kecamatan', 'telepon', 'email'])]
class Puskesmas extends Model
{
    protected $table = 'puskesmas';

    public function posyandus()
    {
        return $this->hasMany(Posyandu::class);
    }
}
