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
        // Pendaftaran user posyandu (kader) dilakukan oleh Dinas Kesehatan.
        // Dinas melihat seluruh posyandu di wilayah kerjanya.
        $posyandus = Posyandu::with('puskesmas')->latest()->get();

        return view('auth.register', compact('posyandus'));
    }

    public function store(RegisterUserRequest $request): RedirectResponse
    {
        $user = User::create($request->validated());

        return redirect()
            ->route('register')
            ->with('status', "Akun {$user->name} berhasil didaftarkan sebagai kader posyandu.");
    }
}
