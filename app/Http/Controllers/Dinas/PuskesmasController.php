<?php

namespace App\Http\Controllers\Dinas;

use App\Http\Controllers\Controller;
use App\Models\DinasKesehatan;
use App\Models\Puskesmas;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PuskesmasController extends Controller
{
    public function index()
    {
        $puskesmas = Puskesmas::with('dinasKesehatan')
            ->latest()
            ->paginate(10);

        return view('dinas.puskesmas.index', compact('puskesmas'));
    }

    public function create()
    {
        $dinas = DinasKesehatan::orderBy('nama_dinas')->get();

        return view('dinas.puskesmas.create', compact('dinas'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'dinas_kesehatan_id' => [
                'required',
                'exists:dinas_kesehatan,id'
            ],
            'nama_puskesmas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        Puskesmas::create($validated);

        return redirect()
            ->route('dinas.puskesmas.index')
            ->with('success', 'Data Puskesmas berhasil ditambahkan.');
    }

    public function edit(Puskesmas $puskesma)
    {
        $dinas = DinasKesehatan::orderBy('nama_dinas')->get();

        return view('dinas.puskesmas.edit', [
            'puskesmas' => $puskesma,
            'dinas' => $dinas,
        ]);
    }

    public function update(Request $request, Puskesmas $puskesma)
    {
        $validated = $request->validate([
            'dinas_kesehatan_id' => [
                'required',
                'exists:dinas_kesehatan,id'
            ],
            'nama_puskesmas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
        ]);

        $puskesma->update($validated);

        return redirect()
            ->route('dinas.puskesmas.index')
            ->with('success', 'Data Puskesmas berhasil diperbarui.');
    }

    public function destroy(Puskesmas $puskesma)
    {
        $puskesma->delete();

        return redirect()
            ->route('dinas.puskesmas.index')
            ->with('success', 'Data Puskesmas berhasil dihapus.');
    }
}
