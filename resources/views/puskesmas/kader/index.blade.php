@extends('layouts.app')

@section('title', '— Akun Kader')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Akun Kader</h1>
            <p class="mt-1 text-sm text-gray-500">Daftar kader pada Posyandu binaan Puskesmas Anda.</p>
        </div>
        <a href="{{ route('puskesmas.kader.create') }}" class="rounded-lg bg-teal-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-teal-800">+ Daftarkan Kader</a>
    </div>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                    <tr><th class="px-5 py-3">Nama Kader</th><th class="px-5 py-3">Email</th><th class="px-5 py-3">Posyandu</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($kader as $akun)
                        <tr>
                            <td class="px-5 py-4 font-semibold text-gray-800">{{ $akun->name }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $akun->email }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $akun->posyandu?->nama_posyandu ?? 'Belum ditempatkan' }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="px-5 py-10 text-center text-gray-500">Belum ada akun kader terdaftar.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($kader->hasPages())<div class="border-t border-gray-100 px-5 py-3">{{ $kader->links() }}</div>@endif
    </div>
</div>
@endsection
