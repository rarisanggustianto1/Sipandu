<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Puskesmas\LaporanBulanan;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class LaporanBulananController extends Controller
{
    public function index(Request $request): View
    {
        $reports = LaporanBulanan::query()
            ->where('puskesmas_id', $request->user()->puskesmas_id)
            ->orderByDesc('tahun')
            ->orderByDesc('bulan')
            ->paginate(12);

        return view('puskesmas.laporan-bulanan.index', compact('reports'));
    }

    public function create(): View
    {
        return view('puskesmas.laporan-bulanan.create', [
            'defaultYear' => now()->year,
            'defaultMonth' => now()->month,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tahun' => ['required', 'integer', 'between:2000,'.now()->year],
            'bulan' => ['required', 'integer', 'between:1,12'],
        ]);

        $period = CarbonImmutable::createFromDate(
            (int) $validated['tahun'],
            (int) $validated['bulan'],
            1,
        )->startOfMonth();

        if ($period->isAfter(now()->startOfMonth())) {
            return back()
                ->withInput()
                ->withErrors(['bulan' => 'Laporan hanya dapat dibuat untuk bulan berjalan atau bulan sebelumnya.']);
        }

        $existingReport = $this->reportQuery($request)
            ->where('tahun', $validated['tahun'])
            ->where('bulan', $validated['bulan'])
            ->first();

        if ($existingReport) {
            return redirect()
                ->route('puskesmas.laporan-bulanan.show', $existingReport)
                ->with('info', 'Laporan untuk periode tersebut sudah tersedia.');
        }

        $report = LaporanBulanan::query()->create([
            'puskesmas_id' => $request->user()->puskesmas_id,
            'tahun' => $validated['tahun'],
            'bulan' => $validated['bulan'],
            'data' => $this->buildReportData(
                (int) $validated['tahun'],
                (int) $validated['bulan'],
                (int) $request->user()->puskesmas_id,
            ),
            'status' => 'draft',
        ]);

        return redirect()
            ->route('puskesmas.laporan-bulanan.show', $report)
            ->with('success', 'Draf laporan bulanan berhasil dibuat. Periksa rekap sebelum mengirim ke Dinas.');
    }

    public function show(Request $request, LaporanBulanan $laporanBulanan): View
    {
        $report = $this->reportQuery($request)
            ->findOrFail($laporanBulanan->id);

        return view('puskesmas.laporan-bulanan.show', compact('report'));
    }

    public function update(Request $request, LaporanBulanan $laporanBulanan): RedirectResponse
    {
        $report = $this->draftReportQuery($request)
            ->findOrFail($laporanBulanan->id);

        $validated = $request->validate([
            'catatan' => ['nullable', 'string', 'max:10000'],
        ]);

        $report->update($validated);

        return redirect()
            ->route('puskesmas.laporan-bulanan.show', $report)
            ->with('success', 'Catatan laporan berhasil disimpan.');
    }

    public function refresh(Request $request, LaporanBulanan $laporanBulanan): RedirectResponse
    {
        $report = $this->draftReportQuery($request)
            ->findOrFail($laporanBulanan->id);

        $report->update([
            'data' => $this->buildReportData(
                $report->tahun,
                $report->bulan,
                (int) $request->user()->puskesmas_id,
            ),
        ]);

        return redirect()
            ->route('puskesmas.laporan-bulanan.show', $report)
            ->with('success', 'Rekap diperbarui dari laporan kegiatan yang sudah selesai.');
    }

    public function submit(Request $request, LaporanBulanan $laporanBulanan): RedirectResponse
    {
        $report = $this->draftReportQuery($request)
            ->findOrFail($laporanBulanan->id);

        $report->update([
            'status' => 'dikirim',
            'dikirim_pada' => now(),
        ]);

        return redirect()
            ->route('puskesmas.laporan-bulanan.show', $report)
            ->with('success', 'Laporan bulanan berhasil dikirim ke Dinas Kesehatan.');
    }

    /**
     * @return array<string, mixed>
     */
    private function buildReportData(int $year, int $month, int $puskesmasId): array
    {
        $period = CarbonImmutable::createFromDate($year, $month, 1)->startOfMonth();

        $meetings = JadwalKegiatan::query()
            ->whereHas('posyandu', fn (Builder $query) => $query
                ->where('puskesmas_id', $puskesmasId))
            ->where('status', 'selesai')
            ->whereBetween('tanggal_kegiatan', [
                $period->toDateString(),
                $period->endOfMonth()->toDateString(),
            ])
            ->with('posyandu:id,nama_posyandu')
            ->withCount([
                'peserta as peserta_hadir_count' => fn (Builder $query) => $query
                    ->where('peserta_kegiatan.status_kehadiran', 'hadir'),
                'pemeriksaans',
                'petugas as petugas_hadir_count' => fn (Builder $query) => $query
                    ->where('kegiatan_petugas.status_kehadiran', 'hadir'),
            ])
            ->orderBy('tanggal_kegiatan')
            ->get();

        $posyanduReports = $meetings
            ->groupBy('posyandu_id')
            ->map(function (Collection $posyanduMeetings): array {
                /** @var JadwalKegiatan $firstMeeting */
                $firstMeeting = $posyanduMeetings->first();

                return [
                    'nama_posyandu' => $firstMeeting->posyandu->nama_posyandu,
                    'jumlah_pertemuan' => $posyanduMeetings->count(),
                    'peserta_hadir' => (int) $posyanduMeetings->sum('peserta_hadir_count'),
                    'pemeriksaan' => (int) $posyanduMeetings->sum('pemeriksaans_count'),
                    'petugas_hadir' => (int) $posyanduMeetings->sum('petugas_hadir_count'),
                    'kegiatan' => $posyanduMeetings->map(fn (JadwalKegiatan $meeting): array => [
                        'nama' => $meeting->nama_kegiatan,
                        'jenis' => $meeting->jenis_kegiatan,
                        'tanggal' => $meeting->tanggal_kegiatan?->toDateString(),
                        'peserta_hadir' => (int) $meeting->peserta_hadir_count,
                        'pemeriksaan' => (int) $meeting->pemeriksaans_count,
                        'petugas_hadir' => (int) $meeting->petugas_hadir_count,
                        'catatan_kader' => $meeting->catatan_laporan,
                    ])->values()->all(),
                ];
            })
            ->values()
            ->all();

        return [
            'dibuat_pada' => now()->toIso8601String(),
            'ringkasan' => [
                'jumlah_pertemuan' => $meetings->count(),
                'peserta_hadir' => (int) $meetings->sum('peserta_hadir_count'),
                'pemeriksaan' => (int) $meetings->sum('pemeriksaans_count'),
                'petugas_hadir' => (int) $meetings->sum('petugas_hadir_count'),
            ],
            'posyandu' => $posyanduReports,
        ];
    }

    private function reportQuery(Request $request): Builder
    {
        return LaporanBulanan::query()
            ->where('puskesmas_id', $request->user()->puskesmas_id);
    }

    private function draftReportQuery(Request $request): Builder
    {
        return $this->reportQuery($request)->where('status', 'draft');
    }
}
