<?php

namespace App\Models\Peserta;

use App\Models\Puskesmas\Posyandu;
use App\Models\User;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function jumlahAnggota(): int
    {
        return $this->peserta()->count();
    }
}
