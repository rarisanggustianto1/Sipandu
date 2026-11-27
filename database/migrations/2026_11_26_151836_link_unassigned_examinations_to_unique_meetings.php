<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\JoinClause;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $examinations = DB::table('pemeriksaan as pemeriksaan')
            ->join('peserta as peserta', 'peserta.id', '=', 'pemeriksaan.peserta_id')
            ->join('keluarga as keluarga', 'keluarga.id', '=', 'peserta.keluarga_id')
            ->join('kegiatan as kegiatan', function (JoinClause $join): void {
                $join->on('kegiatan.posyandu_id', '=', 'keluarga.posyandu_id')
                    ->on('kegiatan.tanggal_kegiatan', '=', 'pemeriksaan.tanggal_pemeriksaan');
            })
            ->whereNull('pemeriksaan.kegiatan_id')
            ->whereNotExists(function (QueryBuilder $query): void {
                $query->selectRaw('1')
                    ->from('kegiatan as kegiatan_lain')
                    ->whereColumn('kegiatan_lain.posyandu_id', 'keluarga.posyandu_id')
                    ->whereColumn('kegiatan_lain.tanggal_kegiatan', 'pemeriksaan.tanggal_pemeriksaan')
                    ->whereColumn('kegiatan_lain.id', '!=', 'kegiatan.id');
            })
            ->select([
                'pemeriksaan.id as pemeriksaan_id',
                'pemeriksaan.peserta_id',
                'kegiatan.id as kegiatan_id',
            ])
            ->orderBy('pemeriksaan.id')
            ->get();

        foreach ($examinations as $examination) {
            DB::table('pemeriksaan')
                ->where('id', $examination->pemeriksaan_id)
                ->whereNull('kegiatan_id')
                ->update(['kegiatan_id' => $examination->kegiatan_id]);

            DB::table('peserta_kegiatan')->insertOrIgnore([
                'kegiatan_id' => $examination->kegiatan_id,
                'peserta_id' => $examination->peserta_id,
                'status_kehadiran' => 'hadir',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    public function down(): void
    {
        // Keep the unambiguous associations; unlinking them could discard valid meeting history.
    }
};
