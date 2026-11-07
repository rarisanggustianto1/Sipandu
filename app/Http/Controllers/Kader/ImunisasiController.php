<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Imunisasi;
use App\Models\Pemeriksaan;
use Illuminate\Http\Request;

class ImunisasiController extends Controller
{
    public function index()
    {
        $imunisasi = Imunisasi::with(['pemeriksaan.peserta'])->latest()->paginate(10);
        return view('kader.imunisasi.index', compact('imunisasi'));
    }

    public function create()
    {
        $pemeriksaan = Pemeriksaan::with('peserta')->latest()->get();
        return view('kader.imunisasi.create', compact('pemeriksaan'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pemeriksaan_id' => 'required|exists:pemeriksaan,id',
            'jenis_vaksin'   => 'nullable|string|max:100',
            'vitamin'        => 'nullable|string|max:100',
            'obat_cacing'    => 'boolean',
            'keterangan'     => 'nullable|string',
        ]);

        Imunisasi::create([
            'pemeriksaan_id' => $request->pemeriksaan_id,
            'jenis_vaksin'   => $request->jenis_vaksin,
            'vitamin'        => $request->vitamin,
            'obat_cacing'    => $request->boolean('obat_cacing'),
            'keterangan'     => $request->keterangan,
        ]);

        return redirect()->route('kader.imunisasi.index')
            ->with('success', 'Data imunisasi & vitamin berhasil ditambahkan.');
    }

    public function show(string $id)
    {
        $imunisasi = Imunisasi::with(['pemeriksaan.peserta', 'pemeriksaan.jadwalKegiatan'])->findOrFail($id);
        return view('kader.imunisasi.show', compact('imunisasi'));
    }

    public function edit(string $id)
    {
        $imunisasi = Imunisasi::findOrFail($id);
        $pemeriksaan = Pemeriksaan::with('peserta')->get();
        return view('kader.imunisasi.edit', compact('imunisasi', 'pemeriksaan'));
    }

    public function update(Request $request, string $id)
    {
        $request->validate([
            'pemeriksaan_id' => 'required|exists:pemeriksaan,id',
            'jenis_vaksin'   => 'nullable|string|max:100',
            'vitamin'        => 'nullable|string|max:100',
            'obat_cacing'    => 'boolean',
            'keterangan'     => 'nullable|string',
        ]);

        $imunisasi = Imunisasi::findOrFail($id);
        $imunisasi->update([
            'pemeriksaan_id' => $request->pemeriksaan_id,
            'jenis_vaksin'   => $request->jenis_vaksin,
            'vitamin'        => $request->vitamin,
            'obat_cacing'    => $request->boolean('obat_cacing'),
            'keterangan'     => $request->keterangan,
        ]);

        return redirect()->route('kader.imunisasi.index')
            ->with('success', 'Data imunisasi berhasil diperbarui.');
    }

    public function destroy(string $id)
    {
        $imunisasi = Imunisasi::findOrFail($id);
        $imunisasi->delete();

        return redirect()->route('kader.imunisasi.index')
            ->with('success', 'Data imunisasi berhasil dihapus.');
    }
}