<?php

namespace App\Http\Controllers\Peserta;

use App\Http\Controllers\Controller;
use App\Models\Keluarga;
use App\Models\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class PesertaController extends Controller
{
    
    public function index(Request $request): View
    {
        $query = Peserta::with('keluarga');

        if ($search = $request->input('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('nik', 'like', "%{$search}%")
                  ->orWhere('nama', 'like', "%{$search}%");
            });
        }

        if ($kategori = $request->input('kategori')) {
            $query->where('kategori', $kategori);
        }

        if ($jenisKelamin = $request->input('jenis_kelamin')) {
            $query->where('jenis_kelamin', $jenisKelamin);
        }

        if ($keluargaId = $request->input('keluarga_id')) {
            $query->where('keluarga_id', $keluargaId);
        }

        $peserta = $query->latest()->paginate(15)->withQueryString();

        return view('peserta.data.index', compact('peserta'));
    }

    public function create(Request $request): View
    {
        $keluargaList = Keluarga::orderBy('nama_kepala_keluarga')->get();

        $selectedKeluargaId = $request->input('keluarga_id');

        return view('peserta.data.create', compact('keluargaList', 'selectedKeluargaId'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'keluarga_id'   => ['required', 'exists:keluarga,id'],
            'nik'           => ['required', 'string', 'size:16', 'unique:peserta,nik'],
            'nama'          => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'kategori'      => ['required', Rule::in(['balita', 'ibu_hamil', 'lansia'])],
        ]);

        Peserta::create($validated);

        return redirect()
            ->route('peserta.data.index')
            ->with('success', 'Data peserta berhasil ditambahkan.');
    }

    public function show(Peserta $datum): View
    {
        $datum->load(['keluarga.posyandu']);

        return view('peserta.data.show', ['peserta' => $datum]);
    }

    public function edit(Peserta $datum): View
    {
        $keluargaList = Keluarga::orderBy('nama_kepala_keluarga')->get();

        return view('peserta.data.edit', [
            'peserta'      => $datum,
            'keluargaList' => $keluargaList,
        ]);
    }

    public function update(Request $request, Peserta $datum): RedirectResponse
    {
        $validated = $request->validate([
            'keluarga_id'   => ['required', 'exists:keluarga,id'],
            'nik'           => ['required', 'string', 'size:16', "unique:peserta,nik,{$datum->id}"],
            'nama'          => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', Rule::in(['L', 'P'])],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'kategori'      => ['required', Rule::in(['balita', 'ibu_hamil', 'lansia'])],
        ]);

        $datum->update($validated);

        return redirect()
            ->route('peserta.data.show', $datum)
            ->with('success', 'Data peserta berhasil diperbarui.');
    }

    public function destroy(Peserta $datum): RedirectResponse
    {
        $datum->delete();

        return redirect()
            ->route('peserta.data.index')
            ->with('success', 'Data peserta berhasil dihapus.');
    }
}
