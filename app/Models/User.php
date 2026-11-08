<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Puskesmas\Puskesmas;
use App\Models\Puskesmas\Posyandu;
use App\Models\Puskesmas\Pengaduan;
use App\Models\Dinas\DinasKesehatan;
use App\Models\Peserta\Keluarga;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'role', 'dinas_kesehatan_id', 'puskesmas_id', 'posyandu_id', 'keluarga_id'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function dinasKesehatan()
    {
        return $this->belongsTo(DinasKesehatan::class, 'dinas_kesehatan_id');
    }

    public function puskesmas()
    {
        return $this->belongsTo(Puskesmas::class);
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class);
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class);
    }

    public function pengaduans()
    {
        return $this->hasMany(Pengaduan::class, 'pelapor_id');
    }
}