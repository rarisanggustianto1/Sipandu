<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePosyanduRequest;
use App\Models\Puskesmas\Posyandu;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PosyanduController extends Controller
{
    public function index(): View
    {
        $posyandu = Posyandu::query()
            ->where('puskesmas_id', auth()->user()->puskesmas_id)
            ->withCount(['pengaduans as total_pengaduan'])
            ->latest()
            ->get();

        return view('puskesmas.posyandu.index', compact('posyandu'));
    }

    public function create(): View
    {
        return view('puskesmas.posyandu.create');
    }

    public function store(StorePosyanduRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        Posyandu::create($validated + [
            'puskesmas_id' => auth()->user()->puskesmas_id,
        ]);

        return redirect()
            ->route('puskesmas.posyandu.index')
            ->with('status', "Posyandu {$validated['nama_posyandu']} berhasil didaftarkan.");
    }
}