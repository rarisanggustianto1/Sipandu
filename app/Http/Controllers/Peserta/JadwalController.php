<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Kader\JadwalKegiatan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class JadwalController extends Controller
{
    public function index(Request $request): View
    {
        $keluarga = $request->user()->keluarga;
        abort_if($keluarga === null, 404);

        $jadwal = JadwalKegiatan::query()
            ->forPosyandu($keluarga->posyandu_id)
            ->whereDate('tanggal_kegiatan', '>=', now()->toDateString())
            ->whereIn('status', ['terjadwal', 'berlangsung'])
            ->orderBy('tanggal_kegiatan')
            ->orderBy('waktu_mulai')
            ->paginate(10);

        return view('peserta.jadwal.index', compact('keluarga', 'jadwal'));
    }
}
