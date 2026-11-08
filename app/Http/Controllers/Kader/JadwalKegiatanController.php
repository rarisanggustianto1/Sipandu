<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Peserta\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class JadwalKegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $jadwal = JadwalKegiatan::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->with('posyandu')
            ->withCount([
                'peserta as peserta_hadir_count' => fn (Builder $query) => $query
                    ->where('peserta_kegiatan.status_kehadiran', 'hadir'),
                'pemeriksaans',
                'petugas as petugas_hadir_count' => fn (Builder $query) => $query
                    ->where('kegiatan_petugas.status_kehadiran', 'hadir'),
            ])
            ->latest('tanggal_kegiatan')
            ->paginate(10);

        return view('kader.jadwal.index', compact('jadwal'));
    }

    public function show(Request $request, string $id): View
    {
        $jadwal = JadwalKegiatan::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->with([
                'posyandu',
                'peserta' => fn (BelongsToMany $query) => $query
                    ->orderBy('nama'),
                'petugas' => fn (BelongsToMany $query) => $query
                    ->wherePivot('status_kehadiran', 'hadir')
                    ->orderBy('name'),
                'pemeriksaans.peserta',
            ])
            ->withCount([
                'peserta as peserta_hadir_count' => fn (Builder $query) => $query
                    ->wherePivot('status_kehadiran', 'hadir'),
                'pemeriksaans',
                'petugas as petugas_hadir_count' => fn (Builder $query) => $query
                    ->wherePivot('status_kehadiran', 'hadir'),
            ])
            ->findOrFail($id);

        $peserta = Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->orderBy('nama')
            ->get();
        $kehadiran = DB::table('peserta_kegiatan')
            ->where('kegiatan_id', $jadwal->id)
            ->pluck('status_kehadiran', 'peserta_id');

        $pertemuanAktif = $this->isActiveToday($jadwal);

        return view('kader.jadwal.show', compact('jadwal', 'peserta', 'kehadiran', 'pertemuanAktif'));
    }

    public function attendance(Request $request, string $id): RedirectResponse
    {
        $jadwal = JadwalKegiatan::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($id);

        abort_unless($this->isActiveToday($jadwal), 403, 'Absensi hanya dapat dicatat pada tanggal pertemuan aktif.');

        $validated = $request->validate([
            'kehadiran' => ['required', 'array'],
            'kehadiran.*' => ['nullable', 'in:hadir,tidak_hadir'],
        ]);

        $statuses = array_filter($validated['kehadiran'], fn (?string $status): bool => $status !== null);
        $participantIds = Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->whereIn('id', array_keys($statuses))
            ->pluck('id')
            ->map(fn (int $id): int => $id)
            ->all();

        abort_unless(count($participantIds) === count($statuses), 404, 'Peserta tidak termasuk Posyandu Anda.');

        DB::transaction(function () use ($jadwal, $statuses): void {
            foreach ($statuses as $participantId => $status) {
                $jadwal->peserta()->syncWithoutDetaching([
                    $participantId => ['status_kehadiran' => $status],
                ]);
            }
        });

        return redirect()->route('kader.jadwal.show', $jadwal)->with('success', 'Absensi peserta dan kehadiran petugas berhasil disimpan.');
    }

    public function checkIn(Request $request, string $id): RedirectResponse
    {
        $jadwal = JadwalKegiatan::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($id);

        abort_unless($this->isActiveToday($jadwal), 403, 'Absensi petugas hanya dapat dicatat pada pertemuan yang sedang berlangsung.');

        $jadwal->petugas()->syncWithoutDetaching([
            $request->user()->id => ['status_kehadiran' => 'hadir'],
        ]);

        return redirect()->route('kader.jadwal.show', $jadwal)->with('success', 'Kehadiran Anda sebagai petugas berhasil dicatat.');
    }

    public function start(Request $request, string $id): RedirectResponse
    {
        $jadwal = JadwalKegiatan::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($id);

        abort_unless($jadwal->tanggal_kegiatan?->isToday(), 403, 'Pertemuan hanya dapat dimulai pada tanggal yang dijadwalkan.');
        abort_unless($jadwal->status === 'terjadwal', 403, 'Pertemuan ini tidak dapat dimulai.');

        $jadwal->update(['status' => 'berlangsung']);

        return redirect()->route('kader.jadwal.show', $jadwal)->with('success', 'Pertemuan Posyandu dimulai.');
    }

    public function finish(Request $request, string $id): RedirectResponse
    {
        $jadwal = JadwalKegiatan::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($id);

        abort_unless($jadwal->tanggal_kegiatan?->isToday(), 403, 'Pertemuan hanya dapat diselesaikan pada tanggal yang dijadwalkan.');
        abort_unless($jadwal->status === 'berlangsung', 403, 'Pertemuan ini belum dimulai.');

        $jadwal->update(['status' => 'selesai']);

        return redirect()->route('kader.jadwal.show', $jadwal)->with('success', 'Pertemuan Posyandu selesai dan laporan telah diperbarui.');
    }

    private function isActiveToday(JadwalKegiatan $jadwal): bool
    {
        return $jadwal->tanggal_kegiatan?->isToday()
            && $jadwal->status === 'berlangsung';
    }
}
