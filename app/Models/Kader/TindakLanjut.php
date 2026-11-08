<?php

namespace App\Models\Kader;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TindakLanjut extends Model
{
    use HasFactory;

    protected $table = 'tindak_lanjut';

    protected $fillable = [
        'pemeriksaan_id',
        'tanggal_pengajuan',
        'alasan_tindak_lanjut',
        'jenis_tindak_lanjut',
        'tanggal_tindak_lanjut',
        'status',
        'hasil_tindak_lanjut',
    ];

    public function pemeriksaan()
    {
        return $this->belongsTo(Pemeriksaan::class);
    }
}
