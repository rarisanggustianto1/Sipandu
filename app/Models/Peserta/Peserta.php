<?php

namespace App\Models\Peserta;

use App\Models\Kader\Imunisasi;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Kader\Pemeriksaan;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

#[Fillable([
    'keluarga_id',
    'nik',
    'nama',
    'jenis_kelamin',
    'tanggal_lahir',
    'kategori',
])]
class Peserta extends Model
{
    use HasFactory;

    protected $table = 'peserta';

    /**
     * Cast atribut ke tipe native.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_lahir' => 'date',
        ];
    }

    public function keluarga(): BelongsTo
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function scopeForPosyandu(Builder $query, ?int $posyanduId): Builder
    {
        return $query->whereHas('keluarga', function (Builder $query) use ($posyanduId): void {
            $query->where('posyandu_id', $posyanduId);
        });
    }

    public function scopeForKeluarga(Builder $query, ?int $keluargaId): Builder
    {
        return $query->where('keluarga_id', $keluargaId);
    }

    public function pemeriksaan(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
    }

    public function pemeriksaanTerbaru(): HasOne
    {
        return $this->hasOne(Pemeriksaan::class)->latestOfMany('tanggal_pemeriksaan');
    }

    public function imunisasi(): HasMany
    {
        return $this->hasMany(Imunisasi::class);
    }

    public function kegiatan(): BelongsToMany
    {
        return $this->belongsToMany(JadwalKegiatan::class, 'peserta_kegiatan', 'peserta_id', 'kegiatan_id')
            ->withPivot(['status_kehadiran', 'catatan'])
            ->withTimestamps();
    }

    public function getUsiaAttribute(): int
    {
        return $this->tanggal_lahir?->age ?? 0;
    }

    public function getLabelJenisKelaminAttribute(): string
    {
        return match ($this->jenis_kelamin) {
            'L' => 'Laki-laki',
            'P' => 'Perempuan',
            default => '-',
        };
    }

    public function getLabelKategoriAttribute(): string
    {
        return match ($this->kategori) {
            'balita' => 'Balita',
            'ibu_hamil' => 'Ibu Hamil',
            'lansia' => 'Lansia',
            default => '-',
        };
    }
}
