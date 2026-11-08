<?php

namespace App\Http\Controllers\Dinas;

use App\Http\Controllers\Controller;
use App\Models\Puskesmas\Puskesmas;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class PuskesmasController extends Controller
{
    public function index(Request $request)
    {
        $puskesmas = Puskesmas::query()
            ->where('dinas_kesehatan_id', $this->dinasKesehatanId($request))
            ->with('dinasKesehatan')
            ->latest()
            ->paginate(10);

        return view('dinas.puskesmas.index', compact('puskesmas'));
    }

    public function create(Request $request)
    {
        $dinas = $request->user()->dinasKesehatan;
        abort_if($dinas === null, 403, 'Akun Dinas Kesehatan belum terhubung dengan data Dinas.');

        return view('dinas.puskesmas.create', compact('dinas'));
    }

    public function store(Request $request)
    {
        $dinasKesehatanId = $this->dinasKesehatanId($request);
        $validated = $request->validate([
            'nama_puskesmas' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:255',
            'telepon' => 'nullable|string|max:20',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email'),
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
            ],
        ]);

        DB::transaction(function () use ($validated, $dinasKesehatanId) {

            $puskesmasData = collect($validated)
                ->except(['password'])
                ->all();
            $puskesmasData['dinas_kesehatan_id'] = $dinasKesehatanId;

            $puskesmas = Puskesmas::create($puskesmasData);

            User::create([
                'name' => $puskesmas->nama_puskesmas,
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => 'tenaga_kesehatan',
                'puskesmas_id' => $puskesmas->id,
            ]);
        });

        return redirect()
            ->route('dinas.puskesmas.index')
            ->with(
                'success',
                'Data Puskesmas dan akun login berhasil ditambahkan.'
            );
    }

    public function edit(Request $request, Puskesmas $puskesma)
    {
        abort_unless(
            (int) $puskesma->dinas_kesehatan_id === $this->dinasKesehatanId($request),
            404
        );
        $dinas = $puskesma->dinasKesehatan;

        return view('dinas.puskesmas.edit', [
            'puskesmas' => $puskesma,
            'dinas' => $dinas,
        ]);
    }

    public function update(Request $request, Puskesmas $puskesma)
    {
        abort_unless(
            (int) $puskesma->dinas_kesehatan_id === $this->dinasKesehatanId($request),
            404
        );
        $validated = $request->validate([
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

    public function destroy(Request $request, Puskesmas $puskesma)
    {
        abort_unless(
            (int) $puskesma->dinas_kesehatan_id === $this->dinasKesehatanId($request),
            404
        );
        $puskesma->delete();

        return redirect()
            ->route('dinas.puskesmas.index')
            ->with('success', 'Data Puskesmas berhasil dihapus.');
    }

    private function dinasKesehatanId(Request $request): int
    {
        $dinasKesehatanId = $request->user()->dinas_kesehatan_id;
        abort_if($dinasKesehatanId === null, 403, 'Akun Dinas Kesehatan belum terhubung dengan data Dinas.');

        return (int) $dinasKesehatanId;
    }
}
