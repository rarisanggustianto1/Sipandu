<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Keluarga;
use App\Models\Peserta\Peserta;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class PesertaController extends Controller
{
    public function index(Request $request): View
    {
        $query = Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->with(['keluarga', 'pemeriksaanTerbaru.balita', 'pemeriksaanTerbaru.bumil', 'pemeriksaanTerbaru.lansia']);

        if ($search = $request->input('search')) {
            $query->where('nama', 'like', "%{$search}%");
        }

        if ($kategori = $request->input('kategori')) {
            $query->where('kategori', $kategori);
        }

        $peserta = $query->latest()->paginate(15)->withQueryString();

        return view('kader.peserta.index', compact('peserta'));
    }

    public function show(Request $request, Peserta $data): View
    {
        abort_unless($data->keluarga()->where('posyandu_id', $request->user()->posyandu_id)->exists(), 404);

        $data->load([
            'keluarga.posyandu',
            'imunisasi' => fn ($query) => $query
                ->orderByRaw('tanggal_pemberian is null')
                ->latest('tanggal_pemberian')
                ->latest('id'),
        ]);
        $riwayat = $data->pemeriksaan()
            ->with(['balita', 'bumil', 'lansia'])
            ->latest('tanggal_pemeriksaan')
            ->latest('id')
            ->get();

        return view('kader.peserta.show', [
            'peserta' => $data,
            'riwayat' => $riwayat,
        ]);
    }

    public function create(Request $request): View
    {
        $keluargaList = Keluarga::query()
            ->where('posyandu_id', $request->user()->posyandu_id)
            ->with('user')
            ->orderBy('nama_kepala_keluarga')
            ->get();

        return view('kader.peserta.create', compact('keluargaList'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'keluarga_id' => ['nullable', 'integer'],
            'no_kk' => ['nullable', 'required_without:keluarga_id', 'string', 'size:16', 'unique:keluarga,no_kk'],
            'nama_kepala_keluarga' => ['nullable', 'required_without:keluarga_id', 'string', 'max:255'],
            'alamat' => ['nullable', 'required_without:keluarga_id', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'nik' => ['required', 'string', 'size:16', 'unique:peserta,nik'],
            'nama' => ['required', 'string', 'max:255'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'kategori' => ['required', 'in:balita,ibu_hamil,lansia'],
        ]);

        $posyanduId = $request->user()->posyandu_id;

        if ($validated['keluarga_id'] ?? false) {
            $keluarga = Keluarga::query()
                ->where('posyandu_id', $posyanduId)
                ->findOrFail($validated['keluarga_id']);
        } else {
            abort_if($posyanduId === null, 403, 'Akun kader belum terhubung ke Posyandu.');
            $keluarga = null;
        }

        if (($keluarga?->user()->exists() ?? false) === false && blank($validated['password'] ?? null)) {
            throw ValidationException::withMessages([
                'password' => 'Password awal wajib diisi untuk membuat akun keluarga.',
            ]);
        }

        DB::transaction(function () use ($validated, $keluarga, $posyanduId): void {
            $keluarga ??= Keluarga::create([
                'posyandu_id' => $posyanduId,
                'no_kk' => $validated['no_kk'],
                'nama_kepala_keluarga' => $validated['nama_kepala_keluarga'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'] ?? null,
            ]);

            if (! $keluarga->user()->exists()) {
                User::create([
                    'name' => $keluarga->nama_kepala_keluarga,
                    'email' => null,
                    'password' => $validated['password'],
                    'role' => 'keluarga',
                    'keluarga_id' => $keluarga->id,
                ]);
            }

            $keluarga->peserta()->create([
                'nik' => $validated['nik'],
                'nama' => $validated['nama'],
                'jenis_kelamin' => $validated['jenis_kelamin'],
                'tanggal_lahir' => $validated['tanggal_lahir'],
                'kategori' => $validated['kategori'],
            ]);
        });

        return redirect()
            ->route('kader.peserta.index')
            ->with('success', 'Data anggota dan akun keluarga berhasil disimpan.');
    }
}
