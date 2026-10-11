<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['dinas_kesehatan_id', 'nama_puskesmas', 'alamat', 'kecamatan', 'telepon', 'email'])]
class Puskesmas extends Model
{
    protected $table = 'puskesmas';

<<<<<<< HEAD
    protected $fillable = [
        'dinas_kesehatan_id',
        'nama_puskesmas',
        'alamat',
        'kecamatan',
        'telepon',
        'email',
    ];

    public function dinasKesehatan(): BelongsTo
    {
        return $this->belongsTo(
            DinasKesehatan::class,
            'dinas_kesehatan_id'
        );
=======
    public function posyandus()
    {
        return $this->hasMany(Posyandu::class);
>>>>>>> origin/feature/puskesmas
    }
}
