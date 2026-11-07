<x-guest-layout>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-slate-50">
        
        <!-- HEADER & LOGO SIPANDU -->
        <div class="flex flex-col items-center mb-6">
            <img src="{{ asset('images/logo-sipandu.jpg') }}" alt="Logo SIPANDU" class="h-16 w-auto rounded-full shadow-md mb-3">
            <h1 class="text-2xl font-bold text-teal-800 tracking-tight">SIPANDU</h1>
            <p class="text-xs text-slate-500 font-medium mt-1">Sistem Informasi Pemantauan Posyandu</p>
        </div>

        <div class="w-full sm:max-w-md px-6 py-6 bg-white shadow-xl rounded-2xl border border-slate-100">
            
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <label for="email" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider mb-1">
                        Email / Username
                    </label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-800 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all outline-none"
                        placeholder="kader@sipandu.id">
                    <x-input-error :messages="$errors->get('email')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center mb-1">
                        <label for="password" class="block text-xs font-semibold text-slate-700 uppercase tracking-wider">
                            Kata Sandi
                        </label>
                        @if (Route::has('password.request'))
                            <a class="text-xs font-medium text-teal-600 hover:text-teal-800 hover:underline" href="{{ route('password.request') }}">
                                Lupa sandi?
                            </a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password"
                        class="w-full px-4 py-2.5 rounded-xl border border-slate-300 text-slate-800 text-sm focus:ring-2 focus:ring-teal-500 focus:border-teal-500 transition-all outline-none"
                        placeholder="••••••••">
                    <x-input-error :messages="$errors->get('password')" class="mt-1 text-xs text-rose-500" />
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between pt-1">
                    <label for="remember_me" class="inline-flex items-center cursor-pointer">
                        <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-teal-600 shadow-sm focus:ring-teal-500" name="remember">
                        <span class="ms-2 text-xs text-slate-600 font-medium">Ingat Saya</span>
                    </label>
                </div>

                <!-- Submit Button -->
                <div class="pt-2">
                    <button type="submit" class="w-full py-3 px-4 bg-teal-600 hover:bg-teal-700 active:bg-teal-800 text-white font-bold text-sm rounded-xl shadow-md transition-all duration-150">
                        Masuk ke Aplikasi
                    </button>
                </div>
            </form>

        </div>

    </div>
</x-guest-layout>