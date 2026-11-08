<?php

namespace App\Http\Controllers\Puskesmas;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreKaderRequest;
use App\Models\Puskesmas\Posyandu;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class KaderController extends Controller
{
    public function index(): View
    {
        $kader = User::query()
            ->where('puskesmas_id', auth()->user()->puskesmas_id)
            ->whereIn('role', ['kader', 'kader_posyandu'])
            ->with('posyandu')
            ->orderBy('name')
            ->paginate(15);

        return view('puskesmas.kader.index', compact('kader'));
    }

    public function create(): View
    {
        $posyandus = Posyandu::query()
            ->where('puskesmas_id', auth()->user()->puskesmas_id)
            ->latest()
            ->get();

        return view('puskesmas.kader.create', compact('posyandus'));
    }

    public function store(StoreKaderRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            // Attribute `hashed` pada model User sudah meng-hash otomatis.
            'password' => $validated['password'],
            'role' => 'kader',
            'posyandu_id' => $validated['posyandu_id'],
            'puskesmas_id' => auth()->user()->puskesmas_id,
        ]);

        return redirect()
            ->route('puskesmas.kader.index')
            ->with('status', "Akun {$validated['name']} berhasil didaftarkan sebagai kader posyandu.");
    }
}
