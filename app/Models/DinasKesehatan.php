<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DinasKesehatan extends Model
{
    protected $table = 'dinas_kesehatan';

    protected $fillable = [
        'nama_dinas',
        'alamat',
        'telepon',
        'email',
    ];

    public function puskesmas(): HasMany
    {
        return $this->hasMany(
            Puskesmas::class,
            'dinas_kesehatan_id'
        );
    }
}
