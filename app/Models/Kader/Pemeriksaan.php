<?php

namespace App\Models\Kader;

use App\Models\Peserta\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pemeriksaan extends Model
{
    use HasFactory;

    protected $table = 'pemeriksaan';

    protected $fillable = [
        'peserta_id',
        'kegiatan_id',
        'tanggal_pemeriksaan',
        'tanggal_periksa',
        'keluhan',
        'catatan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pemeriksaan' => 'date',
        ];
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function kegiatan()
    {
        return $this->belongsTo(JadwalKegiatan::class, 'kegiatan_id');
    }

    public function scopeForPosyandu(Builder $query, ?int $posyanduId): Builder
    {
        return $query->whereHas('peserta', function (Builder $query) use ($posyanduId): void {
            $query->forPosyandu($posyanduId);
        });
    }

    public function balita()
    {
        return $this->hasOne(PemeriksaanBalita::class, 'pemeriksaan_id');
    }

    public function bumil()
    {
        return $this->hasOne(PemeriksaanBumil::class, 'pemeriksaan_id');
    }

    public function lansia()
    {
        return $this->hasOne(PemeriksaanLansia::class, 'pemeriksaan_id');
    }

    public function tindakLanjut()
    {
        return $this->hasOne(TindakLanjut::class, 'pemeriksaan_id');
    }

    public function setTanggalPeriksaAttribute($value): void
    {
        if ($value) {
            $this->attributes['tanggal_pemeriksaan'] = $value;
        }
    }

    public function getTanggalPeriksaAttribute(): ?string
    {
        return $this->attributes['tanggal_pemeriksaan'] ?? null;
    }
}
