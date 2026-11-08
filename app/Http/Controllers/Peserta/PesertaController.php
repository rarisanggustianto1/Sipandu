<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PesertaController extends Controller
{
    public function index(Request $request): View
    {
        $peserta = Peserta::query()
            ->forKeluarga($request->user()->keluarga_id)
            ->with([
                'pemeriksaanTerbaru.balita',
                'pemeriksaanTerbaru.bumil',
                'pemeriksaanTerbaru.lansia',
            ])
            ->latest()
            ->paginate(15);

        return view('peserta.data.index', compact('peserta'));
    }

    public function create(): View
    {
        abort_if(auth()->user()->keluarga_id === null, 403, 'Akun keluarga belum terhubung ke data keluarga.');

        return view('peserta.data.create');
    }

    public function store(Request $request): RedirectResponse
    {
        abort_if($request->user()->keluarga_id === null, 403, 'Akun keluarga belum terhubung ke data keluarga.');

        $validated = $request->validate([
            'nik' => ['required', 'string', 'size:16', 'unique:peserta,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'kategori' => ['required', Rule::in(['balita', 'ibu_hamil', 'lansia'])],
        ]);

        $peserta = Peserta::create([
            ...$validated,
            'keluarga_id' => $request->user()->keluarga_id,
        ]);

        return redirect()
            ->route('peserta.data.show', $peserta)
            ->with('success', 'Anggota keluarga berhasil ditambahkan.');
    }

    public function show(Request $request, Peserta $data): View
    {
        $peserta = $this->authenticatedParticipant($request, $data)
            ->load([
                'keluarga.posyandu',
                'pemeriksaan' => fn ($query) => $query
                    ->with(['balita', 'bumil', 'lansia'])
                    ->latest('tanggal_pemeriksaan')
                    ->latest('id'),
                'imunisasi' => fn ($query) => $query
                    ->orderByRaw('tanggal_pemberian is null')
                    ->latest('tanggal_pemberian')
                    ->latest('id'),
            ]);

        return view('peserta.data.show', compact('peserta'));
    }

    private function authenticatedParticipant(Request $request, Peserta $participant): Peserta
    {
        return Peserta::query()
            ->forKeluarga($request->user()->keluarga_id)
            ->findOrFail($participant->id);
    }
}
