<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Models\Kader\Imunisasi;
use App\Models\Peserta\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImunisasiController extends Controller
{
    public function index(Request $request): View
    {
        $imunisasi = $this->imunisasiQuery($request)
            ->with(['peserta.keluarga.posyandu'])
            ->latest()
            ->paginate(15);

        return view('puskesmas.imunisasi.index', compact('imunisasi'));
    }

    public function create(Request $request): View
    {
        $peserta = $this->pesertaQuery($request)->orderBy('nama')->get();

        return view('puskesmas.imunisasi.form', compact('peserta'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $this->pesertaQuery($request)->findOrFail($validated['peserta_id']);
        Imunisasi::create($validated);

        return redirect()->route('puskesmas.imunisasi.index')->with('success', 'Jadwal imunisasi peserta berhasil ditambahkan.');
    }

    public function edit(Request $request, string $id): View
    {
        $imunisasi = $this->imunisasiQuery($request)->findOrFail($id);
        $peserta = $this->pesertaQuery($request)->orderBy('nama')->get();

        return view('puskesmas.imunisasi.form', compact('imunisasi', 'peserta'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $this->validatedData($request);
        $this->pesertaQuery($request)->findOrFail($validated['peserta_id']);
        $this->imunisasiQuery($request)->findOrFail($id)->update($validated);

        return redirect()->route('puskesmas.imunisasi.index')->with('success', 'Jadwal imunisasi berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $this->imunisasiQuery($request)->findOrFail($id)->delete();

        return redirect()->route('puskesmas.imunisasi.index')->with('success', 'Data imunisasi berhasil dihapus.');
    }

    private function validatedData(Request $request): array
    {
        return $request->validate([
            'peserta_id' => ['required', 'integer', 'exists:peserta,id'],
            'jenis_imunisasi' => ['required', 'string', 'max:255'],
            'tanggal_jadwal' => ['nullable', 'date'],
            'tanggal_pemberian' => ['nullable', 'date'],
            'status' => ['required', 'in:terjadwal,selesai,terlewat'],
            'catatan' => ['nullable', 'string'],
        ]);
    }

    private function pesertaQuery(Request $request): Builder
    {
        return Peserta::query()->whereHas('keluarga.posyandu', fn (Builder $query) => $query
            ->where('puskesmas_id', $request->user()->puskesmas_id));
    }

    private function imunisasiQuery(Request $request): Builder
    {
        return Imunisasi::query()->whereHas('peserta.keluarga.posyandu', fn (Builder $query) => $query
            ->where('puskesmas_id', $request->user()->puskesmas_id));
    }
}
