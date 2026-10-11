<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Peserta;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PesertaDashboardController extends Controller
{
    
    public function __invoke(): View
    {

        $totalKeluarga = Keluarga::count();
        $totalPeserta  = Peserta::count();

        $perKategori = Peserta::select('kategori', DB::raw('COUNT(*) as total'))
            ->groupBy('kategori')
            ->pluck('total', 'kategori');

        $totalBalita   = $perKategori->get('balita', 0);
        $totalIbuHamil = $perKategori->get('ibu_hamil', 0);
        $totalLansia   = $perKategori->get('lansia', 0);

        $perJenisKelamin = Peserta::select('jenis_kelamin', DB::raw('COUNT(*) as total'))
            ->groupBy('jenis_kelamin')
            ->pluck('total', 'jenis_kelamin');

        $totalLakiLaki  = $perJenisKelamin->get('L', 0);
        $totalPerempuan = $perJenisKelamin->get('P', 0);

        $pesertaTerbaru  = Peserta::with('keluarga')
            ->latest()
            ->take(5)
            ->get();

        $keluargaTerbaru = Keluarga::with('posyandu')
            ->withCount('peserta')
            ->latest()
            ->take(5)
            ->get();

        return view('peserta.dashboard', compact(
            'totalKeluarga',
            'totalPeserta',
            'totalBalita',
            'totalIbuHamil',
            'totalLansia',
            'totalLakiLaki',
            'totalPerempuan',
            'pesertaTerbaru',
            'keluargaTerbaru',
        ));
    }
}
