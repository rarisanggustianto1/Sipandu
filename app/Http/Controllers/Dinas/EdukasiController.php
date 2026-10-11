<?php

namespace App\Http\Controllers\Dinas;

use App\Http\Controllers\Controller;
use App\Models\Edukasi;
use Illuminate\Http\Request;

class EdukasiController extends Controller
{
    public function index()
    {
        $edukasi = Edukasi::latest()->paginate(10);

        return view('dinas.edukasi.index', compact('edukasi'));
    }

    public function create()
    {
        return view('dinas.edukasi.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|in:umum,balita,ibu_hamil,lansia',
            'tanggal_publikasi' => 'nullable|date',
            'status_aktif' => 'required|boolean',
        ]);

        Edukasi::create($validated);

        return redirect()
            ->route('dinas.edukasi.index')
            ->with('success', 'Edukasi berhasil ditambahkan.');
    }

    public function edit(Edukasi $edukasi)
    {
        return view('dinas.edukasi.edit', compact('edukasi'));
    }

    public function update(Request $request, Edukasi $edukasi)
    {
        $validated = $request->validate([
            'judul' => 'required|string|max:255',
            'isi' => 'required|string',
            'kategori' => 'required|in:umum,balita,ibu_hamil,lansia',
            'tanggal_publikasi' => 'nullable|date',
            'status_aktif' => 'required|boolean',
        ]);

        $edukasi->update($validated);

        return redirect()
            ->route('dinas.edukasi.index')
            ->with('success', 'Edukasi berhasil diperbarui.');
    }

    public function destroy(Edukasi $edukasi)
    {
        $edukasi->delete();

        return redirect()
            ->route('dinas.edukasi.index')
            ->with('success', 'Edukasi berhasil dihapus.');
    }
}
