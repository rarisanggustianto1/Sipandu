@extends('layouts.app')

@section('title', '— Dashboard Puskesmas')

@section('content')
<div class="space-y-6">

    {{-- Judul --}}
    <div class="flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Dashboard Puskesmas</h1>
            <p class="text-sm text-slate-500">Ringkasan data {{ auth()->user()->name }} pada {{ now()->translatedFormat('d F Y') }}</p>
        </div>
        <a href="{{ route('puskesmas.kader.create') }}"
           class="rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-semibold text-white transition-colors hover:bg-teal-800">
            + Daftarkan Kader
        </a>
    </div>

    {{-- Statistik --}}
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

        <div class="rounded-2xl border border-slate-200 border-l-4 border-l-teal-500 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Keluarga Terdaftar</p>
            <p class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($keluargaCount, 0, ',', '.') }}</p>
            <a href="{{ route('puskesmas.posyandu.index') }}" class="mt-3 inline-block text-xs font-medium text-teal-600 hover:underline">
                Lihat Posyandu &rarr;
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 border-l-4 border-l-emerald-500 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Pemeriksaan Bulan Ini</p>
            <p class="mt-2 text-3xl font-bold text-slate-800">{{ number_format($pemeriksaanBulanIni, 0, ',', '.') }}</p>
            <p class="mt-3 text-xs text-slate-500">{{ now()->translatedFormat('F Y') }}</p>
        </div>

        <div class="rounded-2xl border border-slate-200 border-l-4 border-l-teal-500 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Laporan Bulan Ini</p>
            <p class="mt-2 text-xl font-bold text-slate-800">
                {{ $laporanBulanIni === 'dikirim' ? 'Terkirim ke Dinas' : ($laporanBulanIni === 'draft' ? 'Draf' : 'Belum dibuat') }}
            </p>
            <a href="{{ route('puskesmas.laporan-bulanan.index') }}" class="mt-3 inline-block text-xs font-medium text-teal-700 hover:underline">
                Kelola laporan &rarr;
            </a>
        </div>

        <div class="rounded-2xl border border-slate-200 border-l-4 border-l-teal-500 bg-white p-5 shadow-sm">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Kegiatan Terjadwal</p>
            <p class="mt-2 text-3xl font-bold text-slate-800">{{ $kegiatanTerjadwal->count() }}</p>
            <p class="mt-3 text-xs text-slate-500">Kegiatan mendatang</p>
        </div>
    </div>

    {{-- Peserta per kategori --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold text-slate-800">Peserta per Kategori</h2>

        @if ($pesertaPerKategori->isEmpty())
            <p class="text-sm text-slate-500">Belum ada data peserta.</p>
        @else
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($pesertaPerKategori as $kategori => $total)
                    <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">
                        <span class="text-sm font-medium text-slate-700">{{ ucfirst($kategori) }}</span>
                        <span class="rounded-full bg-emerald-500 px-3 py-1 text-xs font-semibold text-white">{{ $total }}</span>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Kegiatan terjadwal --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
        <h2 class="mb-4 text-lg font-semibold text-slate-800">Kegiatan Terjadwal</h2>

        @if ($kegiatanTerjadwal->isEmpty())
            <p class="text-sm text-slate-500">Belum ada kegiatan terjadwal.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-left text-xs uppercase text-slate-500">
                            <th class="px-3 py-2">Nama Kegiatan</th>
                            <th class="px-3 py-2">Posyandu</th>
                            <th class="px-3 py-2">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach ($kegiatanTerjadwal as $k)
                            <tr>
                                <td class="px-3 py-2 font-medium text-slate-800">{{ $k->nama_kegiatan }}</td>
                                <td class="px-3 py-2 text-slate-700">{{ $k->posyandu?->nama_posyandu }}</td>
                                <td class="px-3 py-2 text-slate-700">
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