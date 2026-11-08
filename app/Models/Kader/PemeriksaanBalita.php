<?php

namespace App\Models\Kader;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemeriksaanBalita extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan_balita';

    protected $fillable = [
        'pemeriksaan_id',
        'berat_badan',
        'tinggi_badan',
        'lingkar_kepala',
        'perkembangan',
        'catatan_gizi',
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }
}
