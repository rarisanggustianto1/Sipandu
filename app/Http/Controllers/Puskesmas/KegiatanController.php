<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Puskesmas\Posyandu;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KegiatanController extends Controller
{
    public function index(Request $request): View
    {
        $kegiatan = JadwalKegiatan::query()
            ->whereHas('posyandu', fn (Builder $query) => $query
                ->where('puskesmas_id', $request->user()->puskesmas_id))
            ->with('posyandu')
            ->withCount([
                'peserta as peserta_hadir_count' => fn (Builder $query) => $query
                    ->where('peserta_kegiatan.status_kehadiran', 'hadir'),
                'pemeriksaans',
                'petugas as petugas_hadir_count' => fn (Builder $query) => $query
                    ->where('kegiatan_petugas.status_kehadiran', 'hadir'),
            ])
            ->latest('tanggal_kegiatan')
            ->paginate(15);

        return view('puskesmas.kegiatan.index', compact('kegiatan'));
    }

    public function show(Request $request, string $id): View
    {
        $kegiatan = $this->kegiatanQuery($request)
            ->with([
                'posyandu',
                'peserta' => fn (BelongsToMany $query) => $query->orderBy('nama'),
                'petugas' => fn (BelongsToMany $query) => $query
                    ->wherePivot('status_kehadiran', 'hadir')
                    ->orderBy('name'),
                'pemeriksaans.peserta',
            ])
            ->withCount([
                'peserta as peserta_hadir_count' => fn (Builder $query) => $query
                    ->where('peserta_kegiatan.status_kehadiran', 'hadir'),
                'pemeriksaans',
                'petugas as petugas_hadir_count' => fn (Builder $query) => $query
                    ->where('kegiatan_petugas.status_kehadiran', 'hadir'),
            ])
            ->findOrFail($id);

        return view('puskesmas.kegiatan.show', compact('kegiatan'));
    }

    public function create(Request $request): View
    {
        $posyandu = $this->posyanduQuery($request)->orderBy('nama_posyandu')->get();

        return view('puskesmas.kegiatan.form', compact('posyandu'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $this->posyanduQuery($request)->findOrFail($validated['posyandu_id']);
        JadwalKegiatan::create($validated);

        return redirect()->route('puskesmas.kegiatan.index')->with('success', 'Kegiatan Posyandu berhasil ditambahkan.');
    }

    public function edit(Request $request, string $id): View
    {
        $kegiatan = $this->kegiatanQuery($request)->findOrFail($id);
        $posyandu = $this->posyanduQuery($request)->orderBy('nama_posyandu')->get();

        return view('puskesmas.kegiatan.form', compact('kegiatan', 'posyandu'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $this->posyanduQuery($request)->findOrFail($validated['posyandu_id']);
        $this->kegiatanQuery($request)->findOrFail($id)->update($validated);

        return redirect()->route('puskesmas.kegiatan.index')->with('success', 'Kegiatan Posyandu berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $this->kegiatanQuery($request)->findOrFail($id)->delete();

        return redirect()->route('puskesmas.kegiatan.index')->with('success', 'Kegiatan Posyandu berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'posyandu_id' => ['required', 'integer', 'exists:posyandu,id'],
            'nama_kegiatan' => ['required', 'string', 'max:255'],
            'jenis_kegiatan' => ['required', 'string', 'max:100'],
            'deskripsi' => ['nullable', 'string'],
            'tanggal_kegiatan' => ['required', 'date'],
            'waktu_mulai' => ['nullable', 'date_format:H:i'],
            'lokasi' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'in:terjadwal,berlangsung,selesai,dibatalkan'],
        ]);
    }

    private function posyanduQuery(Request $request): Builder
    {
        return Posyandu::query()->where('puskesmas_id', $request->user()->puskesmas_id);
    }

    private function kegiatanQuery(Request $request): Builder
    {
        return JadwalKegiatan::query()->whereHas('posyandu', fn (Builder $query) => $query
            ->where('puskesmas_id', $request->user()->puskesmas_id));
    }
}
