<?php

namespace App\Models\Kader;

use App\Models\Peserta\Peserta;
use App\Models\Puskesmas\Posyandu;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JadwalKegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'posyandu_id',
        'nama_kegiatan',
        'jenis_kegiatan',
        'deskripsi',
        'tanggal_kegiatan',
        'waktu_mulai',
        'lokasi',
        'status',
        'jam_mulai',
        'jam_selesai',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
        ];
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }

    public function peserta(): BelongsToMany
    {
        return $this->belongsToMany(Peserta::class, 'peserta_kegiatan', 'kegiatan_id', 'peserta_id')
            ->withPivot(['status_kehadiran', 'catatan'])
            ->withTimestamps();
    }

    public function pemeriksaans(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class, 'kegiatan_id');
    }

    public function petugas(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'kegiatan_petugas', 'kegiatan_id', 'user_id')
            ->withPivot('status_kehadiran')
            ->withTimestamps();
    }

    public function scopeForPosyandu(Builder $query, ?int $posyanduId): Builder
    {
        return $query->where('posyandu_id', $posyanduId);
    }

    public function setJamMulaiAttribute($value): void
    {
        if ($value) {
            $this->attributes['waktu_mulai'] = $value;
        }
    }

    public function getJamMulaiAttribute(): ?string
    {
        return $this->attributes['waktu_mulai'] ?? null;
    }

    public function setKeteranganAttribute($value): void
    {
        if ($value) {
            $this->attributes['deskripsi'] = $value;
        }
    }

    public function getKeteranganAttribute(): ?string
    {
        return $this->attributes['deskripsi'] ?? null;
    }
}
