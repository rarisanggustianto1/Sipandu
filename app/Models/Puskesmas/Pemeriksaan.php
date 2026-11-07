<?php

namespace App\Models\Puskesmas;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;

#[Fillable(['peserta_id', 'tanggal_pemeriksaan', 'keluhan', 'catatan'])]
class Pemeriksaan extends Model
{
    protected $table = 'pemeriksaan';

    protected function casts(): array
    {
        return [
            'tanggal_pemeriksaan' => 'date',
        ];
    }

    public function peserta()
    {
        return $this->belongsTo(Peserta::class);
    }
}