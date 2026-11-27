<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas\Kegiatan;
use App\Models\Puskesmas\Keluarga;
use App\Models\Puskesmas\LaporanBulanan;
use App\Models\Puskesmas\Pemeriksaan;
use App\Models\Puskesmas\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $keluargaCount = Keluarga::query()
            ->whereHas('posyandu', fn (Builder $q) => $q->where('puskesmas_id', $this->puskesmasId()))
            ->count();

        $pesertaPerKategori = Peserta::query()
            ->selectRaw('kategori, COUNT(*) as total')
            ->whereHas('keluarga.posyandu', fn (Builder $q) => $q->where('puskesmas_id', $this->puskesmasId()))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $pemeriksaanBulanIni = Pemeriksaan::query()
            ->whereHas('peserta.keluarga.posyandu', fn (Builder $q) => $q->where('puskesmas_id', $this->puskesmasId()))
            ->whereMonth('tanggal_pemeriksaan', now()->month)
            ->whereYear('tanggal_pemeriksaan', now()->year)
            ->count();

        $kegiatanTerjadwal = Kegiatan::query()
            ->with('posyandu')
            ->whereHas('posyandu', fn (Builder $q) => $q->where('puskesmas_id', $this->puskesmasId()))
            ->where('status', 'terjadwal')
            ->whereDate('tanggal_kegiatan', '>=', now()->toDateString())
            ->orderBy('tanggal_kegiatan')
            ->limit(5)
            ->get();

        $laporanBulanIni = LaporanBulanan::query()
            ->where('puskesmas_id', $this->puskesmasId())
            ->where('tahun', now()->year)
            ->where('bulan', now()->month)
            ->value('status');

        return view('puskesmas.dashboard', compact(
            'keluargaCount',
            'pesertaPerKategori',
            'pemeriksaanBulanIni',
            'kegiatanTerjadwal',
            'laporanBulanIni',
        ));
    }

    private function puskesmasId(): ?int
    {
        return auth()->user()->puskesmas_id;
    }
}
