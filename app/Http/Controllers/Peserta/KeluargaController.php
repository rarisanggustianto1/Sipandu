<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Posyandu;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeluargaController extends Controller
{
    
    public function index(Request $request): View
    {
        $query = Keluarga::with('posyandu')
            ->withCount('peserta');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('no_kk', 'like', "%{$search}%")
                  ->orWhere('nama_kepala_keluarga', 'like', "%{$search}%");
            });
        }

        if ($posyanduId = $request->input('posyandu_id')) {
            $query->where('posyandu_id', $posyanduId);
        }

        $keluarga = $query->latest()->paginate(15)->withQueryString();
        $posyanduList = Posyandu::orderBy('nama_posyandu')->get();

        return view('peserta.keluarga.index', compact('keluarga', 'posyanduList'));
    }

    public function create(): View
    {
        $posyanduList = Posyandu::orderBy('nama_posyandu')->get();

        return view('peserta.keluarga.create', compact('posyanduList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'posyandu_id'          => ['required', 'exists:posyandu,id'],
            'no_kk'                => ['required', 'string', 'size:16', 'unique:keluarga,no_kk'],
            'nama_kepala_keluarga' => ['required', 'string', 'max:255'],
            'alamat'               => ['required', 'string'],
            'no_telepon'           => ['nullable', 'string', 'max:20'],
        ]);

        Keluarga::create($validated);

        return redirect()
            ->route('peserta.keluarga.index')
            ->with('success', 'Data keluarga berhasil ditambahkan.');
    }

    public function show(Keluarga $keluarga): View
    {
        $keluarga->load(['posyandu', 'peserta']);

        return view('peserta.keluarga.show', compact('keluarga'));
    }

    public function edit(Keluarga $keluarga): View
    {
        $posyanduList = Posyandu::orderBy('nama_posyandu')->get();

        return view('peserta.keluarga.edit', compact('keluarga', 'posyanduList'));
    }

    public function update(Request $request, Keluarga $keluarga): RedirectResponse
    {
        $validated = $request->validate([
            'posyandu_id'          => ['required', 'exists:posyandu,id'],
            'no_kk'                => ['required', 'string', 'size:16', "unique:keluarga,no_kk,{$keluarga->id}"],
            'nama_kepala_keluarga' => ['required', 'string', 'max:255'],
            'alamat'               => ['required', 'string'],
            'no_telepon'           => ['nullable', 'string', 'max:20'],
        ]);

        $keluarga->update($validated);

        return redirect()
            ->route('peserta.keluarga.show', $keluarga)
            ->with('success', 'Data keluarga berhasil diperbarui.');
    }

    public function destroy(Keluarga $keluarga): RedirectResponse
    {
        $keluarga->delete();

        return redirect()
            ->route('peserta.keluarga.index')
            ->with('success', 'Data keluarga berhasil dihapus.');
    }
}
