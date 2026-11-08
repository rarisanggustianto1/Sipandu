<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function create(): View
    {
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        $credentials = $request->validated();
        $login = $credentials['login'] ?? $credentials['email'];
        $password = $credentials['password'];
        $authenticated = filter_var($login, FILTER_VALIDATE_EMAIL)
            ? Auth::attempt(['email' => $login, 'password' => $password], $request->boolean('remember'))
            : $this->authenticateFamily($login, $password, $request->boolean('remember'));

        if ($authenticated) {
            $request->session()->regenerate();
            $request->session()->forget('url.intended');

            return redirect()->route('home');
        }

        return back()
            ->withErrors(['login' => 'Email atau No. KK / kata sandi salah.'])
            ->onlyInput('login');
    }

    private function authenticateFamily(string $noKk, string $password, bool $remember): bool
    {
        $user = User::query()
            ->where('role', 'keluarga')
            ->whereHas('keluarga', fn ($query) => $query->where('no_kk', $noKk))
            ->first();

        if (! $user || ! Hash::check($password, $user->password)) {
            return false;
        }

        Auth::login($user, $remember);

        return true;
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
