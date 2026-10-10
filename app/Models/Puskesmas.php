<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Puskesmas extends Model
{
    protected $table = 'puskesmas';

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
    }
}
