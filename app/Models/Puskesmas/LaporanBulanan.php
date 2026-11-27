<?php

namespace App\Models\Puskesmas;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable(['puskesmas_id', 'tahun', 'bulan', 'data', 'catatan', 'status', 'dikirim_pada'])]
class LaporanBulanan extends Model
{
    protected $table = 'laporan_bulanan';

    protected function casts(): array
    {
        return [
            'data' => 'array',
            'dikirim_pada' => 'datetime',
        ];
    }

    public function puskesmas(): BelongsTo
    {
        return $this->belongsTo(Puskesmas::class);
    }
}
