<?php

namespace App\Models\Kader;

use App\Models\Peserta\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imunisasi extends Model
{
    use HasFactory;

    protected $table = 'imunisasi';

    protected $fillable = [
        'peserta_id',
        'jenis_imunisasi',
        'tanggal_jadwal',
        'tanggal_pemberian',
        'status',
        'catatan',
        'pemeriksaan_id',
        'jenis_vaksin',
        'vitamin',
        'obat_cacing',
        'keterangan',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_jadwal' => 'date',
            'tanggal_pemberian' => 'date',
        ];
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class, 'peserta_id');
    }

    public function scopeForPosyandu(Builder $query, ?int $posyanduId): Builder
    {
        return $query->whereHas('peserta', function (Builder $query) use ($posyanduId): void {
            $query->forPosyandu($posyanduId);
        });
    }

    public function setJenisVaksinAttribute($value): void
    {
        if ($value) {
            $this->attributes['jenis_imunisasi'] = $value;
        }
    }

    public function getJenisVaksinAttribute(): ?string
    {
        return $this->attributes['jenis_imunisasi'] ?? null;
    }

    public function setKeteranganAttribute($value): void
    {
        if ($value) {
            $this->attributes['catatan'] = $value;
        }
    }

    public function getKeteranganAttribute(): ?string
    {
        return $this->attributes['catatan'] ?? null;
    }
}
