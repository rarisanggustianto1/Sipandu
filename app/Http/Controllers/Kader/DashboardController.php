<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Kader\Pemeriksaan;
use App\Models\Peserta\Peserta;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $posyanduId = $user->posyandu_id;

        $pesertaQuery = Peserta::query()->forPosyandu($posyanduId);

        $totalPeserta = (clone $pesertaQuery)->count();
        $totalBalita = (clone $pesertaQuery)->where('kategori', 'balita')->count();
        $totalBumil = (clone $pesertaQuery)->where('kategori', 'ibu_hamil')->count();
        $totalLansia = (clone $pesertaQuery)->where('kategori', 'lansia')->count();

        $kegiatanBerikutnya = JadwalKegiatan::query()
            ->where('posyandu_id', $posyanduId)
            ->whereDate('tanggal_kegiatan', '>=', now()->toDateString())
            ->whereIn('status', ['terjadwal', 'berlangsung'])
            ->orderByRaw("case when status = 'berlangsung' then 0 else 1 end")
            ->orderBy('tanggal_kegiatan')
            ->first();

        $pemeriksaanTerbaru = Pemeriksaan::query()
            ->forPosyandu($posyanduId)
            ->with(['peserta', 'balita', 'bumil', 'lansia'])
            ->latest('tanggal_pemeriksaan')
            ->latest('id')
            ->limit(5)
            ->get();

        $namaPosyandu = $user->posyandu?->nama_posyandu ?? 'Posyandu belum diatur';

        return view('kader.dashboard', compact(
            'namaPosyandu',
            'totalPeserta',
            'totalBalita',
            'totalBumil',
            'totalLansia',
            'kegiatanBerikutnya',
            'pemeriksaanTerbaru',
        ));
    }
}
