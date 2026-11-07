<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'posyandu_id',
    'no_kk',
    'nama_kepala_keluarga',
    'alamat',
    'no_telepon',
])]
class Keluarga extends Model
{
    use HasFactory;

    protected $table = 'keluarga';

    public function posyandu(): BelongsTo
    {
        return $this->belongsTo(Posyandu::class);
    }
    public function peserta(): HasMany
    {
        return $this->hasMany(Peserta::class);
    }

    public function jumlahAnggota(): int
    {
        return $this->peserta()->count();
    }
}
