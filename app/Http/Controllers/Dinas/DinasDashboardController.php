<?php

namespace App\Http\Controllers\Dinas;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas;
use Illuminate\Support\Facades\DB;

class DinasDashboardController extends Controller
{
    public function index()
    {
        $totalPuskesmas = Puskesmas::count();

        $totalPosyandu = DB::table('posyandu')->count();

        $totalKeluarga = DB::table('keluarga')->count();

        $totalPeserta = DB::table('peserta')->count();

        return view('dinas.dashboard', compact(
            'totalPuskesmas',
            'totalPosyandu',
            'totalKeluarga',
            'totalPeserta'
        ));
    }
}