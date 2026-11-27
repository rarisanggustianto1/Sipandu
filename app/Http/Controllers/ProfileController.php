<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function index(): View
    {
        return view('profile.index', ['user' => auth()->user()]);
    }

    public function update(UpdateProfileRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $user = $request->user();
        $emailChanged = array_key_exists('email', $data) && $user->email !== $data['email'];

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $user->fill($data);

        if ($emailChanged) {
            $user->email_verified_at = null;
        }

        $user->save();

        return redirect()->route('profile')->with('status', 'Profil berhasil diperbarui.');
    }
}
