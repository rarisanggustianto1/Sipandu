<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function pemeriksaan(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class);
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
            'balita'    => 'Balita',
            'ibu_hamil' => 'Ibu Hamil',
            'lansia'    => 'Lansia',
            default     => '-',
        };
    }
}
