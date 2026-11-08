<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Peserta;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesertaController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:255'],
            'kategori' => ['nullable', 'in:balita,ibu_hamil,lansia'],
        ]);

        $query = $this->puskesmasParticipants($request)
            ->with([
                'keluarga.posyandu',
                'pemeriksaanTerbaru.balita',
                'pemeriksaanTerbaru.bumil',
                'pemeriksaanTerbaru.lansia',
            ]);

        if ($search = $validated['search'] ?? null) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($kategori = $validated['kategori'] ?? null) {
            $query->where('kategori', $kategori);
        }

        $peserta = $query->orderBy('nama')->paginate(15)->withQueryString();

        return view('puskesmas.peserta.index', compact('peserta'));
    }

    public function show(Request $request, Peserta $data): View
    {
        $peserta = $this->puskesmasParticipants($request)
            ->with([
                'keluarga.posyandu',
                'imunisasi' => fn (HasMany $query) => $query
                    ->orderByRaw('tanggal_pemberian is null')
                    ->latest('tanggal_pemberian')
                    ->latest('id'),
            ])
            ->findOrFail($data->id);

        $riwayat = $peserta->pemeriksaan()
            ->with(['balita', 'bumil', 'lansia'])
            ->latest('tanggal_pemeriksaan')
            ->latest('id')
            ->get();

        return view('puskesmas.peserta.show', compact('peserta', 'riwayat'));
    }

    private function puskesmasParticipants(Request $request): Builder
    {
        return Peserta::query()
            ->whereHas('keluarga.posyandu', fn (Builder $query) => $query
                ->where('puskesmas_id', $request->user()->puskesmas_id));
    }
}
