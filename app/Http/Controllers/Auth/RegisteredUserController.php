<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Peserta\Keluarga;
use App\Models\Puskesmas\Posyandu;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        $posyandu = Posyandu::query()
            ->orderBy('nama_posyandu')
            ->get();

        return view('auth.register', compact('posyandu'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'no_kk' => ['required', 'digits:16', 'unique:keluarga,no_kk'],
            'nama_kepala_keluarga' => ['required', 'string', 'max:255'],
            'posyandu_id' => ['required', 'integer', 'exists:posyandu,id'],
            'alamat' => ['required', 'string'],
            'no_telepon' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = DB::transaction(function () use ($validated): User {
            $keluarga = Keluarga::create([
                'posyandu_id' => $validated['posyandu_id'],
                'no_kk' => $validated['no_kk'],
                'nama_kepala_keluarga' => $validated['nama_kepala_keluarga'],
                'alamat' => $validated['alamat'],
                'no_telepon' => $validated['no_telepon'] ?? null,
            ]);

            return User::create([
                'name' => $keluarga->nama_kepala_keluarga,
                'email' => null,
                'password' => $validated['password'],
                'role' => 'keluarga',
                'keluarga_id' => $keluarga->id,
            ]);
        });

        Auth::login($user);
        $request->session()->regenerate();

        return redirect()->route('home');
    }
}
