<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edukasi extends Model
{
    protected $table = 'edukasi';

    protected $fillable = [
        'judul',
        'isi',
        'kategori',
        'gambar',
        'tanggal_publikasi',
        'status_aktif',
    ];

    protected $casts = [
        'tanggal_publikasi' => 'date',
        'status_aktif' => 'boolean',
    ];
}
