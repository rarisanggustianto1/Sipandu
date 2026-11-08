<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Models\Kader\TindakLanjut;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TindakLanjutController extends Controller
{
    public function index(Request $request): View
    {
        $tindakLanjut = $this->tindakLanjutQuery($request)
            ->with('pemeriksaan.peserta.keluarga.posyandu')
            ->latest('tanggal_pengajuan')
            ->paginate(15);

        return view('puskesmas.tindak-lanjut.index', compact('tindakLanjut'));
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $validated = $request->validate([
            'status' => ['required', 'in:diajukan,diproses,selesai'],
            'jenis_tindak_lanjut' => ['nullable', 'string', 'max:255'],
            'tanggal_tindak_lanjut' => ['nullable', 'date'],
            'hasil_tindak_lanjut' => ['nullable', 'string'],
        ]);

        $this->tindakLanjutQuery($request)->findOrFail($id)->update($validated);

        return redirect()->route('puskesmas.tindak-lanjut.index')->with('success', 'Status tindak lanjut berhasil diperbarui.');
    }

    private function tindakLanjutQuery(Request $request): Builder
    {
        return TindakLanjut::query()->whereHas('pemeriksaan.peserta.keluarga.posyandu', fn (Builder $query) => $query
            ->where('puskesmas_id', $request->user()->puskesmas_id));
    }
}
