<?php

namespace App\Http\Controllers;

use App\Models\Pengaduan;
use App\Models\Posyandu;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class PuskesmasDashboardController extends Controller
{
    public function index(): JsonResponse
    {
        $puskesmasId = auth()->user()->puskesmas_id;

        $posyanduCount = Posyandu::where('puskesmas_id', $puskesmasId)->count();

        $keluargaCount = DB::table('keluarga')
            ->join('posyandu', 'keluarga.posyandu_id', '=', 'posyandu.id')
            ->where('posyandu.puskesmas_id', $puskesmasId)
            ->count();

        $pesertaPerKategori = DB::table('peserta')
            ->join('keluarga', 'peserta.keluarga_id', '=', 'keluarga.id')
            ->join('posyandu', 'keluarga.posyandu_id', '=', 'posyandu.id')
            ->where('posyandu.puskesmas_id', $puskesmasId)
            ->select('peserta.kategori as kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('peserta.kategori')
            ->pluck('total', 'kategori');

        $pemeriksaanBulanIni = DB::table('pemeriksaan')
            ->join('peserta', 'pemeriksaan.peserta_id', '=', 'peserta.id')
            ->join('keluarga', 'peserta.keluarga_id', '=', 'keluarga.id')
            ->join('posyandu', 'keluarga.posyandu_id', '=', 'posyandu.id')
            ->where('posyandu.puskesmas_id', $puskesmasId)
            ->whereMonth('pemeriksaan.tanggal_pemeriksaan', now()->month)
            ->whereYear('pemeriksaan.tanggal_pemeriksaan', now()->year)
            ->count();

        $pengaduanPerStatus = Pengaduan::whereHas('posyandu', function ($query) use ($puskesmasId) {
            $query->where('puskesmas_id', $puskesmasId);
        })
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $kegiatanTerjadwal = DB::table('kegiatan')
            ->join('posyandu', 'kegiatan.posyandu_id', '=', 'posyandu.id')
            ->where('posyandu.puskesmas_id', $puskesmasId)
            ->where('kegiatan.status', 'terjadwal')
            ->whereDate('kegiatan.tanggal_kegiatan', '>=', now()->toDateString())
            ->orderBy('kegiatan.tanggal_kegiatan')
            ->limit(5)
            ->get([
                'kegiatan.id',
                'kegiatan.nama_kegiatan',
                'kegiatan.tanggal_kegiatan',
                'posyandu.nama_posyandu',
            ]);

        return response()->json([
            'puskesmas_id' => $puskesmasId,
            'ringkasan' => [
                'posyandu' => $posyanduCount,
                'keluarga' => $keluargaCount,
                'peserta_per_kategori' => $pesertaPerKategori,
                'pemeriksaan_bulan_ini' => $pemeriksaanBulanIni,
            ],
            'pengaduan_per_status' => $pengaduanPerStatus,
            'kegiatan_terjadwal' => $kegiatanTerjadwal,
        ]);
    }
}
