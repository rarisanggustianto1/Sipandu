<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterUserRequest;
use App\Models\Posyandu;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RegisterController extends Controller
{
    public function create(): View
    {
        // Pendaftaran kader dilakukan oleh Admin Puskesmas.
        // Hanya posyandu milik puskesmas ini yang bisa dipilih.
        $posyandus = Posyandu::where('puskesmas_id', auth()->user()->puskesmas_id)
            ->latest()
            ->get();

        return view('auth.register', compact('posyandus'));
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        return redirect()
            ->route('puskesmas.kader.create')
            ->with('status', "Akun {$user->name} berhasil didaftarkan sebagai kader posyandu.");
    }
}
