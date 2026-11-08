@extends('layouts.app')

@section('title', isset($kegiatan) ? '— Ubah Kegiatan' : '— Tambah Kegiatan')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <a href="{{ route('puskesmas.kegiatan.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Kembali ke kegiatan</a>
        <h1 class="mt-3 text-2xl font-bold text-gray-800">{{ isset($kegiatan) ? 'Ubah Kegiatan' : 'Tambah Kegiatan Posyandu' }}</h1>
    </div>

    @if ($errors->any())
        <div class="rounded-lg bg-rose-50 p-4 text-sm text-rose-800"><p class="font-semibold">Periksa kembali data kegiatan:</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif

    <form method="POST" action="{{ isset($kegiatan) ? route('puskesmas.kegiatan.update', $kegiatan) : route('puskesmas.kegiatan.store') }}" class="space-y-4 rounded-xl bg-white p-5 shadow-sm sm:p-6">
        @csrf
        @if (isset($kegiatan)) @method('PUT') @endif
        <label class="block text-sm font-semibold text-gray-700">Posyandu
            <select name="posyandu_id" required class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                <option value="">Pilih Posyandu</option>
                @foreach ($posyandu as $lokasi)
                    <option value="{{ $lokasi->id }}" @selected((string) old('posyandu_id', $kegiatan->posyandu_id ?? '') === (string) $lokasi->id)>{{ $lokasi->nama_posyandu }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm font-semibold text-gray-700">Nama kegiatan
            <input name="nama_kegiatan" required maxlength="255" value="{{ old('nama_kegiatan', $kegiatan->nama_kegiatan ?? '') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
        </label>
        <label class="block text-sm font-semibold text-gray-700">Jenis kegiatan
            <input name="jenis_kegiatan" required maxlength="100" placeholder="Contoh: Posyandu rutin, kelas ibu hamil" value="{{ old('jenis_kegiatan', $kegiatan->jenis_kegiatan ?? '') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
        </label>
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="block text-sm font-semibold text-gray-700">Tanggal
                <input type="date" name="tanggal_kegiatan" required value="{{ old('tanggal_kegiatan', isset($kegiatan) ? $kegiatan->tanggal_kegiatan?->format('Y-m-d') : '') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
            </label>
            <label class="block text-sm font-semibold text-gray-700">Waktu
                <input type="time" name="waktu_mulai" value="{{ old('waktu_mulai', isset($kegiatan) ? substr((string) $kegiatan->waktu_mulai, 0, 5) : '') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
            </label>
        </div>
        <label class="block text-sm font-semibold text-gray-700">Lokasi
            <input name="lokasi" maxlength="255" value="{{ old('lokasi', $kegiatan->lokasi ?? '') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
        </label>
        <label class="block text-sm font-semibold text-gray-700">Deskripsi
            <textarea name="deskripsi" rows="3" class="mt-1 w-full rounded-lg border-gray-300 text-sm">{{ old('deskripsi', $kegiatan->deskripsi ?? '') }}</textarea>
        </label>
        <label class="block text-sm font-semibold text-gray-700">Status
            <select name="status" required class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                @foreach (['terjadwal' => 'Terjadwal', 'berlangsung' => 'Berlangsung', 'selesai' => 'Selesai', 'dibatalkan' => 'Dibatalkan'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $kegiatan->status ?? 'terjadwal') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </label>
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('puskesmas.kegiatan.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">Batal</a>
            <button type="submit" class="rounded-lg bg-teal-700 px-5 py-2 text-sm font-bold text-white hover:bg-teal-800">Simpan Kegiatan</button>
        </div>
    </form>
</div>
@endsection
