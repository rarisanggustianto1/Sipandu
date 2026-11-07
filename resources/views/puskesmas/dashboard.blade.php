@extends('layouts.app')

@section('title', '— Dashboard Puskesmas')

@section('content')
<div class="space-y-6">

    {{-- Judul --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Puskesmas</h1>
            <p class="text-sm text-gray-500">Ringkasan data {{ auth()->user()->name }} pada {{ now()->translatedFormat('d F Y') }}</p>
        </div>
        <a href="{{ route('puskesmas.kader.create') }}"
           class="rounded-md bg-blue-500 px-4 py-2 text-sm font-medium text-white transition-colors hover:bg-blue-600">
            + Daftarkan Kader
        </a>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        <div class="rounded-lg border-l-4 border-teal-500 bg-white p-5 shadow">
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Keluarga Terdaftar</p>
            <p class="mt-2 text-3xl font-bold text-gray-800">{{ number_format($keluargaCount, 0, ',', '.') }}</p>
            <a href="{{ route('puskesmas.posyandu.index') }}" class="mt-3 inline-block text-xs font-medium text-teal-600 hover:underline">
                Lihat Posyandu &rarr;
            </a>
        </div>

        <div class="rounded-lg border-l-4 border-emerald-500 bg-white p-5 shadow">
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Pemeriksaan Bulan Ini</p>
            <p class="mt-2 text-3xl font-bold text-gray-800">{{ number_format($pemeriksaanBulanIni, 0, ',', '.') }}</p>
            <p class="mt-3 text-xs text-gray-500">{{ now()->translatedFormat('F Y') }}</p>
        </div>

        <div class="rounded-lg border-l-4 border-rose-500 bg-white p-5 shadow">
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Total Pengaduan</p>
            <p class="mt-2 text-3xl font-bold text-gray-800">{{ number_format($totalPengaduan, 0, ',', '.') }}</p>
            <a href="{{ route('puskesmas.pengaduan.index') }}" class="mt-3 inline-block text-xs font-medium text-rose-600 hover:underline">
                Kelola Pengaduan &rarr;
            </a>
        </div>

        <div class="rounded-lg border-l-4 border-blue-500 bg-white p-5 shadow">
            <p class="text-xs font-medium uppercase tracking-wide text-gray-500">Kegiatan Terjadwal</p>
            <p class="mt-2 text-3xl font-bold text-gray-800">{{ $kegiatanTerjadwal->count() }}</p>
            <p class="mt-3 text-xs text-gray-500">Kegiatan mendatang</p>
        </div>
    </div>

    {{-- Peserta per kategori --}}
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold text-gray-800">Peserta per Kategori</h2>

        @if ($pesertaPerKategori->isEmpty())
            <p class="text-sm text-gray-500">Belum ada data peserta.</p>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($pesertaPerKategori as $kategori => $total)
                    <div class="flex items-center justify-between rounded-md bg-gray-50 px-4 py-3">
                        <span class="text-sm font-medium text-gray-700">{{ ucfirst($kategori) }}</span>
                        <span class="rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-white">{{ $total }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Status pengaduan --}}
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold text-gray-800">Status Pengaduan</h2>

        @if ($pengaduanPerStatus->isEmpty())
            <p class="text-sm text-gray-500">Belum ada pengaduan masuk.</p>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">
                @foreach (\App\Http\Controllers\Puskesmas\PengaduanController::STATUS as $key)
                    <div class="rounded-md border border-gray-200 px-4 py-3">
                        <p class="text-xs font-medium uppercase tracking-wide text-gray-500">{{ ucfirst($key) }}</p>
                        <p class="mt-1 text-2xl font-bold text-gray-800">{{ $pengaduanPerStatus[$key] ?? 0 }}</p>
                        <x-puskesmas.status-badge :status="$key" class="mt-2" />
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Kegiatan terjadwal --}}
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="mb-4 text-lg font-semibold text-gray-800">Kegiatan Terjadwal</h2>

        @if ($kegiatanTerjadwal->isEmpty())
            <p class="text-sm text-gray-500">Belum ada kegiatan terjadwal.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase text-gray-500">
                            <th class="px-3 py-2">Nama Kegiatan</th>
                            <th class="px-3 py-2">Posyandu</th>
                            <th class="px-3 py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($kegiatanTerjadwal as $k)
                            <tr>
                                <td class="px-3 py-2 font-medium text-gray-800">{{ $k->nama_kegiatan }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $k->posyandu?->nama_posyandu }}</td>
                                <td class="px-3 py-2 text-gray-700">
                                    {{ \Carbon\Carbon::parse($k->tanggal_kegiatan)->translatedFormat('d F Y') }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection