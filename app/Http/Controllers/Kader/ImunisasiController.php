<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kader\Imunisasi;
use App\Models\Peserta\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImunisasiController extends Controller
{
    public function index(Request $request): View
    {
        $imunisasi = Imunisasi::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->with('peserta')
            ->latest()
            ->paginate(10);

        return view('kader.imunisasi.index', compact('imunisasi'));
    }

    public function create(Request $request): View
    {
        $peserta = Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->orderBy('nama')
            ->get();

        return view('kader.imunisasi.create', compact('peserta'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'peserta_id' => ['required', 'integer', 'exists:peserta,id'],
            'jenis_imunisasi' => ['nullable', 'string', 'max:100'],
            'jenis_vaksin' => ['nullable', 'string', 'max:100'],
            'tanggal_jadwal' => ['nullable', 'date'],
            'tanggal_pemberian' => ['nullable', 'date'],
            'status' => ['nullable', 'in:terjadwal,selesai,terlewat'],
            'catatan' => ['nullable', 'string'],
        ]);

        Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($validated['peserta_id']);

        if (empty($validated['jenis_imunisasi']) && ! empty($validated['jenis_vaksin'])) {
            $validated['jenis_imunisasi'] = $validated['jenis_vaksin'];
        }

        if (empty($validated['jenis_imunisasi'])) {
            $validated['jenis_imunisasi'] = 'Imunisasi Rutin';
        }

        if (empty($validated['status'])) {
            $validated['status'] = ! empty($validated['tanggal_pemberian']) ? 'selesai' : 'terjadwal';
        }

        Imunisasi::create($validated);

        return redirect()
            ->route('kader.imunisasi.index')
            ->with('success', 'Data imunisasi & vitamin berhasil disimpan.');
    }

    public function show(Request $request, string $id): View
    {
        $imunisasi = Imunisasi::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->with('peserta')
            ->findOrFail($id);

        return view('kader.imunisasi.show', compact('imunisasi'));
    }

    public function edit(Request $request, string $id): View
    {
        $imunisasi = Imunisasi::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($id);
        $peserta = Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->orderBy('nama')
            ->get();

        return view('kader.imunisasi.edit', compact('imunisasi', 'peserta'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'peserta_id' => ['required', 'integer', 'exists:peserta,id'],
            'jenis_imunisasi' => ['nullable', 'string', 'max:100'],
            'jenis_vaksin' => ['nullable', 'string', 'max:100'],
            'tanggal_jadwal' => ['nullable', 'date'],
            'tanggal_pemberian' => ['nullable', 'date'],
            'status' => ['nullable', 'in:terjadwal,selesai,terlewat'],
            'catatan' => ['nullable', 'string'],
        ]);

        Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($validated['peserta_id']);

        if (empty($validated['jenis_imunisasi']) && ! empty($validated['jenis_vaksin'])) {
            $validated['jenis_imunisasi'] = $validated['jenis_vaksin'];
        }

        $imunisasi = Imunisasi::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($id);
        $imunisasi->update($validated);

        return redirect()
            ->route('kader.imunisasi.index')
            ->with('success', 'Data imunisasi berhasil diperbarui.');
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $imunisasi = Imunisasi::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($id);
        $imunisasi->delete();

        return redirect()
            ->route('kader.imunisasi.index')
            ->with('success', 'Data imunisasi berhasil dihapus.');
    }
}
