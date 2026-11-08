<?php

namespace App\Models\Kader;

use App\Models\Puskesmas\Posyandu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatan';

    protected $fillable = [
        'posyandu_id',
        'nama_kegiatan',
        'jenis_kegiatan',
        'deskripsi',
        'tanggal_kegiatan',
        'waktu_mulai',
        'lokasi',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_kegiatan' => 'date',
        ];
    }

    public function posyandu()
    {
        return $this->belongsTo(Posyandu::class, 'posyandu_id');
    }
}
