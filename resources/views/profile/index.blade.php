@extends('layouts.app')

@section('title', '— Profil')

@section('content')
@php
    $roleLabel = match ($user->role) {
        'kader', 'kader_posyandu' => 'Kader Posyandu',
        'keluarga', 'peserta' => 'Keluarga / Peserta',
        'dinas', 'dinas_kesehatan' => 'Dinas Kesehatan',
        'puskesmas' => 'Puskesmas',
        default => ucwords(str_replace('_', ' ', $user->role)),
    };
@endphp

<div class="mx-auto max-w-6xl">
    <header class="sticky top-0 z-10 -mx-4 -mt-16 border-b border-slate-200 bg-white/95 px-4 py-4 shadow-sm backdrop-blur lg:-mx-8 lg:-mt-6 lg:px-8">
        <div class="mx-auto flex max-w-6xl flex-wrap items-center justify-between gap-3 pl-12 lg:pl-0">
            <div>
                <p class="text-xs font-semibold uppercase tracking-[0.16em] text-teal-700">Pengaturan akun</p>
                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">Profil Saya</h1>
            </div>
            <a href="{{ route('home') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition-colors hover:border-teal-200 hover:bg-teal-50 hover:text-teal-800">
                <x-puskesmas.icon name="grid" class="h-4 w-4" />
                Ke Dashboard
            </a>
        </div>
    </header>

    <div class="space-y-6 py-6">
        @if (session('status'))
            <div role="status" class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-800">
                {{ session('status') }}
            </div>
        @endif

        <div class="grid items-start gap-6 lg:grid-cols-[minmax(17rem,0.8fr)_minmax(0,1.5fr)]">
            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                <div class="flex items-center gap-4">
                    <span class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl bg-teal-100 text-xl font-bold text-teal-800">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="text-xs font-semibold uppercase tracking-wide text-teal-700">Identitas Akun</p>
                        <h2 class="mt-1 break-words text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                        <span class="mt-1 inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $roleLabel }}</span>
                    </div>
                </div>

                <dl class="mt-6 divide-y divide-slate-100">
                    <div class="py-3">
                        <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Email</dt>
                        <dd class="mt-1 break-all text-sm font-medium text-slate-800">{{ $user->email ?: 'Belum ditambahkan' }}</dd>
                    </div>
                    @if ($user->keluarga?->no_kk)
                        <div class="py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Nomor Kartu Keluarga</dt>
                            <dd class="mt-1 text-sm font-medium text-slate-800">{{ $user->keluarga->no_kk }}</dd>
                        </div>
                    @endif
                    @if ($user->puskesmas)
                        <div class="py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Puskesmas</dt>
                            <dd class="mt-1 text-sm font-medium text-slate-800">{{ $user->puskesmas->nama_puskesmas }}</dd>
                        </div>
                    @endif
                    @if ($user->posyandu)
                        <div class="py-3">
                            <dt class="text-xs font-medium uppercase tracking-wide text-slate-500">Posyandu</dt>
                            <dd class="mt-1 text-sm font-medium text-slate-800">{{ $user->posyandu->nama_posyandu }}</dd>
                        </div>
                    @endif
                </dl>
            </section>

            <section class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
                <div class="mb-6">
                    <h2 class="text-xl font-bold text-slate-900">Informasi Profil</h2>
                    <p class="mt-1 text-sm text-slate-500">Perbarui nama, email, atau kata sandi akun Anda.</p>
                </div>

                <form method="POST" action="{{ route('profile') }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid gap-5 sm:grid-cols-2">
                        <div class="sm:col-span-2">
                            <label for="name" class="block text-sm font-semibold text-slate-700">Nama Lengkap</label>
                            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required autocomplete="name"
                                   aria-invalid="{{ $errors->has('name') ? 'true' : 'false' }}"
                                   class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-teal-600 focus:bg-white focus:ring-4 focus:ring-teal-600/10">
                            @error('name')
                                <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="sm:col-span-2">
                            <label for="email" class="block text-sm font-semibold text-slate-700">
                                Email{{ $user->role === 'keluarga' ? ' (opsional)' : '' }}
                            </label>
                            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" @required($user->role !== 'keluarga')
                                   autocomplete="email"
                                   aria-invalid="{{ $errors->has('email') ? 'true' : 'false' }}"
                                   class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-teal-600 focus:bg-white focus:ring-4 focus:ring-teal-600/10">
                            @error('email')
                                <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="border-t border-slate-200 pt-6">
                        <h3 class="text-base font-bold text-slate-900">Keamanan Akun</h3>
                        <p class="mt-1 text-sm text-slate-500">Kosongkan jika tidak ingin mengganti kata sandi.</p>

                        <div class="mt-4 grid gap-5 sm:grid-cols-2">
                            <div>
                                <label for="password" class="block text-sm font-semibold text-slate-700">Kata Sandi Baru</label>
                                <input type="password" name="password" id="password" autocomplete="new-password"
                                       aria-invalid="{{ $errors->has('password') ? 'true' : 'false' }}"
                                       class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-teal-600 focus:bg-white focus:ring-4 focus:ring-teal-600/10">
                                @error('password')
                                    <p class="mt-1.5 text-sm text-rose-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-slate-700">Ulangi Kata Sandi Baru</label>
                                <input type="password" name="password_confirmation" id="password_confirmation" autocomplete="new-password"
                                       class="mt-2 w-full rounded-xl border border-slate-300 bg-slate-50 px-3.5 py-3 text-sm text-slate-900 shadow-sm outline-none transition focus:border-teal-600 focus:bg-white focus:ring-4 focus:ring-teal-600/10">
                            </div>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 border-t border-slate-200 pt-5">
                        <p class="text-xs text-slate-500">Perubahan akan diterapkan ke akun {{ $roleLabel }} Anda.</p>
                        <button type="submit" class="inline-flex items-center justify-center rounded-xl bg-teal-700 px-5 py-3 text-sm font-semibold text-white shadow-sm transition-colors hover:bg-teal-800 focus:outline-none focus:ring-4 focus:ring-teal-700/20">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
