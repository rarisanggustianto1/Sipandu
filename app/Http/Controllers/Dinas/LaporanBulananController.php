<?php

namespace App\Http\Controllers\Dinas;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas\LaporanBulanan;
use App\Models\Puskesmas\Puskesmas;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LaporanBulananController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'tahun' => ['nullable', 'integer', 'between:2000,'.now()->year],
            'bulan' => ['nullable', 'integer', 'between:1,12'],
            'puskesmas' => ['nullable', 'integer'],
        ]);

        $query = $this->submittedReports($request)
            ->when(
                $validated['tahun'] ?? null,
                fn (Builder $query, int $year) => $query->where('tahun', $year),
            )
            ->when(
                $validated['bulan'] ?? null,
                fn (Builder $query, int $month) => $query->where('bulan', $month),
            )
            ->when(
                $validated['puskesmas'] ?? null,
                fn (Builder $query, int $puskesmasId) => $query->where('puskesmas_id', $puskesmasId),
            );

        $totalReports = (clone $query)->count();
        $puskesmasTerlibat = (clone $query)->distinct()->count('puskesmas_id');
        $reports = $query
            ->with('puskesmas:id,nama_puskesmas')
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->paginate(15)
            ->withQueryString();

        $puskesmasList = Puskesmas::query()
            ->where('dinas_kesehatan_id', $request->user()->dinas_kesehatan_id)
            ->orderBy('nama_puskesmas')
            ->get(['id', 'nama_puskesmas']);

        return view('dinas.laporan.index', compact(
            'reports',
            'puskesmasList',
            'totalReports',
            'puskesmasTerlibat',
        ));
    }

    public function show(Request $request, LaporanBulanan $laporanBulanan): View
    {
        $report = $this->submittedReports($request)
            ->with('puskesmas:id,nama_puskesmas,kecamatan')
            ->findOrFail($laporanBulanan->id);

        return view('dinas.laporan.show', compact('report'));
    }

    private function submittedReports(Request $request): Builder
    {
        return LaporanBulanan::query()
            ->where('status', 'dikirim')
            ->whereHas('puskesmas', fn (Builder $query) => $query
                ->where('dinas_kesehatan_id', $request->user()->dinas_kesehatan_id));
    }
}
