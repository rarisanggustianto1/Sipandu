@extends('layouts.app')

@section('title', '— Tambah Kader Posyandu')

@section('content')
<div class="max-w-2xl space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">Form Pendaftaran Kader Posyandu</h1>

    <div class="rounded-lg bg-white p-6 shadow">
        @if ($posyandus->isEmpty())
            <div class="text-sm text-gray-500">
                <p class="mb-3">Belum ada Posyandu terdaftar. Buat Posyandu terlebih dahulu sebelum mendaftarkan Kader.</p>
                <a href="{{ route('puskesmas.posyandu.create') }}"
                   class="inline-block rounded-md px-4 py-2 text-sm font-medium text-white bg-emerald-500 hover:bg-emerald-600 transition-colors">
                    + Buat Posyandu
                </a>
            </div>
        @else
            <form method="POST" action="{{ route('puskesmas.kader.store') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="posyandu_id" class="block text-sm font-medium text-gray-700">Posyandu</label>
                    <select name="posyandu_id" id="posyandu_id" required
                            class="mt-1 w-full rounded-md border-gray-300 text-sm shadow-sm">
                        <option value="">-- Pilih Posyandu --</option>
                        @foreach ($posyandus as $p)
                            <option value="{{ $p->id }}" @selected(old('posyandu_id') == $p->id)>
                                {{ $p->nama_posyandu }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Kader</label>
                    <input type="text" name="name" id="name" required
                           value="{{ old('name') }}"
                           class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" id="email" required
                           value="{{ old('email') }}"
                           class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Kata Sandi</label>
                    <input type="password" name="password" id="password" required
                           class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Ulangi Kata Sandi</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" required
                           class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                </div>

                <div class="flex gap-3">
                    <button type="submit" class="rounded-md px-4 py-2 text-sm font-medium text-white bg-blue-500 hover:bg-blue-600 transition-colors">Daftarkan Kader</button>
                    <a href="{{ route('puskesmas.dashboard') }}"
                       class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
                </div>
            </form>
        @endif
    </div>

</div>
@endsection