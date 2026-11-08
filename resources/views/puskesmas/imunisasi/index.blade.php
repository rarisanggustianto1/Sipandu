@extends('layouts.app')

@section('title', '— Kelola Imunisasi')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Kelola Imunisasi</h1>
            <p class="mt-1 text-sm text-gray-500">Jadwal dan riwayat imunisasi peserta dari Posyandu binaan Anda.</p>
        </div>
        <a href="{{ route('puskesmas.imunisasi.create') }}" class="rounded-lg bg-teal-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-teal-800">+ Tambah Imunisasi</a>
    </div>

    @if (session('success'))<div class="rounded-lg bg-emerald-50 p-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>@endif

    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                    <tr><th class="px-5 py-3">Peserta</th><th class="px-5 py-3">Posyandu</th><th class="px-5 py-3">Jenis</th><th class="px-5 py-3">Jadwal</th><th class="px-5 py-3">Pemberian</th><th class="px-5 py-3">Status</th><th class="px-5 py-3">Aksi</th></tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($imunisasi as $item)
                        <tr>
                            <td class="px-5 py-4 font-semibold text-gray-800">{{ $item->peserta->nama }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $item->peserta->keluarga->posyandu->nama_posyandu }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $item->jenis_imunisasi }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $item->tanggal_jadwal?->format('d M Y') ?? '-' }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $item->tanggal_pemberian?->format('d M Y') ?? '-' }}</td>
                            <td class="px-5 py-4"><span class="rounded-full bg-teal-50 px-2.5 py-1 text-xs font-semibold text-teal-800">{{ ucfirst($item->status) }}</span></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <a href="{{ route('puskesmas.imunisasi.edit', $item) }}" class="font-semibold text-teal-700 hover:underline">Ubah</a>
                                    <form method="POST" action="{{ route('puskesmas.imunisasi.destroy', $item) }}" onsubmit="return confirm('Hapus data imunisasi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="font-semibold text-rose-600 hover:underline">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="px-5 py-10 text-center text-gray-500">Belum ada data imunisasi.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($imunisasi->hasPages())<div class="border-t border-gray-100 px-5 py-3">{{ $imunisasi->links() }}</div>@endif
    </div>
</div>
@endsection
