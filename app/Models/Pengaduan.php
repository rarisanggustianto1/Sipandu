<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['pelapor_id', 'posyandu_id', 'judul', 'deskripsi', 'jenis', 'status', 'tanggapan_puskesmas'])]
class Pengaduan extends Model
{
    protected $table = 'pengaduan';

    public function pelapor()
    {
        return $this->belongsTo(User::class, 'pelapor_id');
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }
}
