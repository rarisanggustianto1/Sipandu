<?php

namespace App\Models\Kader;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanLansia extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_lansia';

    protected $fillable = [
        'pemeriksaan_id',
        'tekanan_darah',
        'gula_darah',
        'kolesterol',
        'asam_urat',
        'berat_badan',
        'catatan_kesehatan',
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }
}
