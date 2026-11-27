<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Masuk - SIPANDU</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen font-sans text-slate-900 antialiased">
    <main class="relative flex min-h-screen items-center justify-center overflow-hidden px-4 py-8 sm:px-6"
          style="background: linear-gradient(135deg, #064e4a 0%, #08716b 55%, #0d7d76 100%);">
        <div class="pointer-events-none absolute inset-0 opacity-20"
             style="background-image: radial-gradient(circle at 20% 20%, rgba(255,255,255,.18) 0 1px, transparent 1px), radial-gradient(circle at 80% 70%, rgba(255,255,255,.12) 0 1px, transparent 1px); background-size: 44px 44px, 62px 62px;"></div>

        <a href="{{ route('home') }}"
           class="absolute left-5 top-5 z-10 inline-flex items-center gap-2 rounded-lg px-3 py-2 text-xs font-semibold text-white/80 transition hover:bg-white/10 hover:text-white sm:left-8 sm:top-7">
            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 18l-6-6 6-6"/>
            </svg>
            Kembali ke Beranda
        </a>

        <div class="relative z-[1] grid w-full max-w-[760px] overflow-hidden rounded-2xl bg-white p-2 shadow-[0_24px_80px_rgba(2,44,42,.38)] md:grid-cols-[1fr_1.06fr]">
            <section class="hidden min-h-[430px] flex-col justify-between rounded-xl px-9 py-7 text-white md:flex"
                     style="background: linear-gradient(155deg, #123b3a 0%, #0a5c57 100%);">
                <x-sipandu-brand subtitle="Kesehatan Keluarga" light />

                <div>
                    <div class="mb-5 grid h-10 w-10 place-items-center rounded-full border border-white/10 bg-white/5 text-teal-200">
                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78L12 21.23l8.84-8.84a5.5 5.5 0 000-7.78z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3.5 12h5l2-3 3 6 2-3h5"/>
                        </svg>
                    </div>
                    <h2 class="text-xl font-extrabold leading-snug">PANTAU KESEHATAN<br>KELUARGA ANDA</h2>
                    <p class="mt-3 max-w-[250px] text-xs leading-5 text-teal-50/70">
                        Meluncurkan layanan kesehatan di jangkauan Posyandu untuk memantau tumbuh kembang dan kebutuhan kesehatan keluarga Anda.
                    </p>
                </div>

                <div class="flex items-center justify-between text-[9px] text-teal-100/55">
                    <span>Kementerian Kesehatan RI</span>
                    <span>Laporkan Bug & Masukan</span>
                </div>
            </section>

            <section class="flex min-h-[430px] flex-col justify-center px-6 py-10 sm:px-10">
                <header class="mb-7">
                    <h1 class="text-xl font-black tracking-tight text-slate-900">SELAMAT DATANG</h1>
                    <p class="mt-1 text-[11px] text-slate-400">Silakan masuk untuk melanjutkan ke layanan.</p>
                </header>

                @if ($errors->any())
                    <div class="mb-4 rounded-lg bg-rose-50 px-3 py-2 text-xs text-rose-700 ring-1 ring-rose-100">
                        {{ $errors->first() }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-4">
                    @csrf

                    <div>
                        <label for="login" class="mb-1.5 block text-[10px] font-bold uppercase tracking-wide text-slate-500">
                            NIK / No. Kartu Keluarga
                        </label>
                        <input type="text" name="login" id="login" value="{{ old('login') }}" required autofocus
                               placeholder="Masukkan NIK atau nomor KK"
                               autocomplete="username"
                               class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 text-sm text-slate-800 placeholder:text-slate-400 focus:border-teal-700 focus:outline-none focus:ring-3 focus:ring-teal-700/10">
                    </div>

                    <div>
                        <label for="password" class="mb-1.5 block text-[10px] font-bold uppercase tracking-wide text-slate-500">
                            Kata Sandi / PIN
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password" required
                                   placeholder="••••••••"
                                   autocomplete="current-password"
                                   class="h-11 w-full rounded-lg border border-slate-200 bg-slate-50 px-3.5 pr-11 text-sm text-slate-800 placeholder:text-slate-400 focus:border-teal-700 focus:outline-none focus:ring-3 focus:ring-teal-700/10">
                            <button type="button" id="toggle-password"
                                    class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-teal-700"
                                    aria-label="Tampilkan kata sandi">
                                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.5 12s3.5-6 9.5-6 9.5 6 9.5 6-3.5 6-9.5 6-9.5-6-9.5-6z"/>
                                    <circle cx="12" cy="12" r="2.5"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="flex items-center justify-between text-[10px]">
                        <label class="inline-flex items-center gap-2 text-slate-500">
                            <input type="checkbox" name="remember" class="h-3.5 w-3.5 rounded border-slate-300 text-teal-700 focus:ring-teal-700">
                            Ingat saya
                        </label>
                        <a href="{{ route('password.request') }}" class="font-semibold text-teal-700 hover:text-teal-800">Lupa kata sandi?</a>
                    </div>

                    <button type="submit"
                            class="h-11 w-full rounded-lg bg-teal-700 text-xs font-bold text-white shadow-sm transition hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-700/20">
                        Masuk
                    </button>
                </form>

                <p class="mt-4 text-center text-[10px] text-slate-400">
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="font-bold text-teal-700 hover:text-teal-800">Hubungi Kader Posyandu</a>
                </p>
            </section>
        </div>

        <div class="absolute bottom-5 z-[1] flex flex-wrap items-center justify-center gap-5 text-[9px] text-teal-50/55 sm:gap-10">
            <span>Maybank| Sobat Amal</span>
            <span>Posyandu</span>
            <span>Kementerian Kesehatan</span>
        </div>
    </main>

    <script>
        const passwordInput = document.getElementById('password');
        const togglePassword = document.getElementById('toggle-password');

        togglePassword?.addEventListener('click', () => {
            const isPassword = passwordInput.type === 'password';
            passwordInput.type = isPassword ? 'text' : 'password';
            togglePassword.setAttribute('aria-label', isPassword ? 'Sembunyikan kata sandi' : 'Tampilkan kata sandi');
        });
    </script>
</body>
</html>
