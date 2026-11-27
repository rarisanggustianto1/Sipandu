<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Peserta\Keluarga;
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

        $kegiatanBerikutnya = JadwalKegiatan::query()
            ->forPosyandu($keluarga->posyandu_id)
            ->whereDate('tanggal_kegiatan', '>=', now()->toDateString())
            ->whereIn('status', ['terjadwal', 'berlangsung'])
            ->orderBy('tanggal_kegiatan')
            ->orderBy('waktu_mulai')
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
