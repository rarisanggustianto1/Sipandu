@extends('layouts.app')

@section('title', '— Daftar User Posyandu')

@section('content')
<div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow">
    <h1 class="mb-1 text-xl font-bold">Daftar User Posyandu</h1>
    <p class="mb-4 text-sm text-gray-600">
        Pendaftaran akun kader posyandu dilakukan oleh Dinas Kesehatan.
    </p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="block text-sm font-medium">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label for="role" class="block text-sm font-medium">Role</label>
            <select name="role" id="role" class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                {{-- Pendaftaran role lain menyusul: form tiap role berbeda-beda --}}
                <option value="kader" selected>Kader Posyandu</option>
            </select>
        </div>

        <div>
            <label for="posyandu_id" class="block text-sm font-medium">Posyandu</label>
            <select name="posyandu_id" id="posyandu_id" required
                    class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                <option value="">— Pilih Posyandu —</option>
                @foreach ($posyandus as $posyandu)
                    <option value="{{ $posyandu->id }}" {{ old('posyandu_id') == $posyandu->id ? 'selected' : '' }}>
                        {{ $posyandu->nama_posyandu }} — {{ $posyandu->puskesmas->nama_puskesmas }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Kata Sandi</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium">Ulangi Kata Sandi</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <button type="submit"
                class="w-full rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Daftarkan
        </button>
    </form>
</div>
@endsection
