<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Keluarga;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KeluargaController extends Controller
{
    public function index(Request $request): View
    {
        $keluarga = $this->authenticatedFamily($request)
            ->load([
                'posyandu',
                'peserta.pemeriksaanTerbaru.balita',
                'peserta.pemeriksaanTerbaru.bumil',
                'peserta.pemeriksaanTerbaru.lansia',
            ]);

        return view('peserta.keluarga.index', compact('keluarga'));
    }

    public function edit(Request $request, Keluarga $keluarga): View
    {
        $keluarga = $this->authenticatedFamily($request, $keluarga);

        return view('peserta.keluarga.edit', compact('keluarga'));
    }

    public function update(Request $request, Keluarga $keluarga): RedirectResponse
    {
        $keluarga = $this->authenticatedFamily($request, $keluarga);
        $validated = $request->validate([
            'nama_kepala_keluarga' => ['required', 'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
        ]);

        $keluarga->update($validated);

        return redirect()
            ->route('peserta.keluarga.index')
            ->with('success', 'Profil keluarga berhasil diperbarui.');
    }

    private function authenticatedFamily(Request $request, ?Keluarga $routeFamily = null): Keluarga
    {
        $query = Keluarga::query()->whereKey($request->user()->keluarga_id);

        if ($routeFamily) {
            $query->whereKey($routeFamily->id);
        }

        return $query->firstOrFail();
    }
}
