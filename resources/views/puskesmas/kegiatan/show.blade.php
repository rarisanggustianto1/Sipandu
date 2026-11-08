@extends('layouts.app')

@section('title', '— Laporan Pertemuan Posyandu')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <a href="{{ route('puskesmas.kegiatan.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Kembali ke kegiatan</a>
            <h1 class="mt-3 text-2xl font-bold text-gray-800">Laporan {{ $kegiatan->nama_kegiatan }}</h1>
            <p class="mt-1 text-sm text-gray-500">{{ $kegiatan->posyandu->nama_posyandu }} · {{ $kegiatan->tanggal_kegiatan?->translatedFormat('l, d F Y') }} · {{ $kegiatan->waktu_mulai ?? 'Waktu belum ditentukan' }}</p>
        </div>
        <span class="rounded-full bg-teal-50 px-3 py-1.5 text-xs font-bold text-teal-800">{{ ucfirst($kegiatan->status) }}</span>
    </div>

    <section class="grid gap-4 sm:grid-cols-3">
        <div class="rounded-xl bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">Peserta hadir</p><p class="mt-2 text-3xl font-black text-gray-800">{{ $kegiatan->peserta_hadir_count }}</p></div>
        <div class="rounded-xl bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">Pemeriksaan dilakukan</p><p class="mt-2 text-3xl font-black text-gray-800">{{ $kegiatan->pemeriksaans_count }}</p></div>
        <div class="rounded-xl bg-white p-5 shadow-sm"><p class="text-sm text-gray-500">Petugas hadir</p><p class="mt-2 text-3xl font-black text-gray-800">{{ $kegiatan->petugas_hadir_count }}</p></div>
    </section>

    <section class="grid gap-6 lg:grid-cols-2">
        <div class="rounded-xl bg-white p-5 shadow-sm">
            <h2 class="font-bold text-gray-800">Absensi peserta</h2>
            <div class="mt-4 divide-y divide-gray-100">
                @forelse ($kegiatan->peserta as $anggota)
                    <div class="flex items-center justify-between gap-3 py-3">
                        <div><p class="font-semibold text-gray-800">{{ $anggota->nama }}</p><p class="text-xs text-gray-500">{{ $anggota->label_kategori }}</p></div>
                        <span class="rounded-full px-2.5 py-1 text-xs font-semibold {{ $anggota->pivot->status_kehadiran === 'hadir' ? 'bg-emerald-50 text-emerald-800' : 'bg-gray-100 text-gray-600' }}">{{ $anggota->pivot->status_kehadiran === 'hadir' ? 'Hadir' : 'Tidak hadir' }}</span>
                    </div>
                @empty
                    <p class="py-4 text-sm text-gray-500">Belum ada absensi peserta.</p>
                @endforelse
            </div>
        </div>

        <div class="space-y-6">
            <div class="rounded-xl bg-white p-5 shadow-sm">
                <h2 class="font-bold text-gray-800">Petugas yang hadir</h2>
                <div class="mt-4 divide-y divide-gray-100">
                    @forelse ($kegiatan->petugas as $petugas)
                        <p class="py-3 text-sm font-medium text-gray-700">{{ $petugas->name }}</p>
                    @empty
                        <p class="py-3 text-sm text-gray-500">Belum ada petugas melakukan absensi.</p>
                    @endforelse
                </div>
            </div>
            <div class="rounded-xl bg-white p-5 shadow-sm">
                <h2 class="font-bold text-gray-800">Pemeriksaan pertemuan</h2>
                <div class="mt-4 divide-y divide-gray-100">
                    @forelse ($kegiatan->pemeriksaans as $pemeriksaan)
                        <div class="py-3">
                            <p class="font-semibold text-gray-800">{{ $pemeriksaan->peserta->nama }}</p>
                            <p class="mt-0.5 text-xs text-gray-500">{{ $pemeriksaan->peserta->label_kategori }} · {{ $pemeriksaan->tanggal_pemeriksaan?->format('d M Y') }}</p>
                        </div>
                    @empty
                        <p class="py-3 text-sm text-gray-500">Belum ada pemeriksaan pada pertemuan ini.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
