@extends('layouts.app')

@section('title', '— Masuk')

@section('content')
<div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow">
    <h1 class="mb-4 text-xl font-bold">Masuk ke SIPANDU</h1>

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="block text-sm font-medium">Email</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required autofocus
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Kata Sandi</label>
            <input type="password" name="password" id="password" required
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <label class="flex items-center gap-2 text-sm">
            <input type="checkbox" name="remember" class="rounded border-gray-300">
            Ingat saya
        </label>

        <button type="submit"
                class="w-full rounded-md bg-blue-600 px-4 py-2 text-white hover:bg-blue-700">
            Masuk
        </button>
    </form>
</div>
@endsection
