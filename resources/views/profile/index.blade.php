@extends('layouts.app')

@section('title', '— Profil')

@section('content')
<div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow">
    <h1 class="mb-4 text-xl font-bold">Profil Saya</h1>

    <dl class="mb-6 space-y-2 text-sm">
        <div>
            <dt class="font-medium">Nama</dt>
            <dd>{{ $user->name }}</dd>
        </div>
        <div>
            <dt class="font-medium">Email</dt>
            <dd>{{ $user->email }}</dd>
        </div>
        <div>
            <dt class="font-medium">Role</dt>
            <dd>{{ $user->role }}</dd>
        </div>
        @if ($user->puskesmas)
            <div>
                <dt class="font-medium">Puskesmas</dt>
                <dd>{{ $user->puskesmas->nama_puskesmas }}</dd>
            </div>
        @endif
        @if ($user->posyandu)
            <div>
                <dt class="font-medium">Posyandu</dt>
                <dd>{{ $user->posyandu->nama_posyandu }}</dd>
            </div>
        @endif
    </dl>

    <h2 class="mb-3 text-lg font-semibold">Ubah Profil</h2>

    <form method="POST" action="{{ route('profile') }}" class="space-y-4">
        @csrf
        @method('PUT')

        <div>
            <label for="name" class="block text-sm font-medium">Nama Lengkap</label>
            <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Kata Sandi Baru (opsional)</label>
            <input type="password" name="password" id="password"
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium">Ulangi Kata Sandi Baru</label>
            <input type="password" name="password_confirmation" id="password_confirmation"
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <button type="submit"
                class="w-full rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Simpan
        </button>
    </form>
</div>
@endsection
