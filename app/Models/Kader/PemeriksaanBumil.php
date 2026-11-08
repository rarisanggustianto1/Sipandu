<?php

namespace App\Models\Kader;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanBumil extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_bumil';

    protected $fillable = [
        'pemeriksaan_id',
        'usia_kehamilan',
        'berat_badan',
        'tekanan_darah',
        'tinggi_fundus',
        'denyut_jantung_janin',
        'catatan_kehamilan',
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }
}
