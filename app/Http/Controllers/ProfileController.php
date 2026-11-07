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

        if (blank($data['password'])) {
            unset($data['password']);
        }

        $request->user()->update($data);

        return redirect()->route('profile')->with('status', 'Profil berhasil diperbarui.');
    }
}
