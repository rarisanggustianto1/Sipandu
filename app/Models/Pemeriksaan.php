<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

    protected $fillable = [
        'jadwal_kegiatan_id',
        'peserta_id',
        'user_id', // Kader yang menginput
        'tanggal_periksa',
        'keluhan',
        'catatan',
    ];

    public function jadwalKegiatan()
    {
        return $this->belongsTo(JadwalKegiatan::class, 'jadwal_kegiatan_id');
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function kader()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pengukuran()
    {
        return $this->hasOne(Pengukuran::class, 'pemeriksaan_id');
    }

    public function imunisasi()
    {
        return $this->hasMany(Imunisasi::class, 'pemeriksaan_id');
    }
}