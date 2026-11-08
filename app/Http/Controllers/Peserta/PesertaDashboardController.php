<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Keluarga;
use App\Models\Puskesmas\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesertaDashboardController extends Controller
{
    public function __invoke(Request $request): View
    {
        $keluarga = Keluarga::query()
            ->with([
                'posyandu',
                'peserta.pemeriksaanTerbaru.balita',
                'peserta.pemeriksaanTerbaru.bumil',
                'peserta.pemeriksaanTerbaru.lansia',
            ])
            ->whereKey($request->user()->keluarga_id)
            ->firstOrFail();

        $peserta = $keluarga->peserta;
        $perKategori = $peserta->countBy('kategori');
        $totalBalita = $perKategori->get('balita', 0);
        $totalIbuHamil = $perKategori->get('ibu_hamil', 0);
        $totalLansia = $perKategori->get('lansia', 0);
        $totalPeserta = $peserta->count();

        $kegiatanBerikutnya = Kegiatan::query()
            ->where('posyandu_id', $keluarga->posyandu_id)
            ->whereDate('tanggal_kegiatan', '>=', now()->toDateString())
            ->orderBy('tanggal_kegiatan')
            ->first();

        $pesertaTerbaru = $peserta->sortByDesc('created_at')->take(5);

        return view('peserta.dashboard', compact(
            'keluarga',
            'totalPeserta',
            'totalBalita',
            'totalIbuHamil',
            'totalLansia',
            'pesertaTerbaru',
            'kegiatanBerikutnya',
        ));
    }
}
