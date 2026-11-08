@extends('layouts.app')

@section('title', isset($imunisasi) ? '— Ubah Imunisasi' : '— Tambah Imunisasi')

@section('content')
<div class="mx-auto max-w-3xl space-y-6">
    <div>
        <a href="{{ route('puskesmas.imunisasi.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Kembali ke imunisasi</a>
        <h1 class="mt-3 text-2xl font-bold text-gray-800">{{ isset($imunisasi) ? 'Ubah Data Imunisasi' : 'Tambah Jadwal Imunisasi' }}</h1>
    </div>
    @if ($errors->any())
        <div class="rounded-lg bg-rose-50 p-4 text-sm text-rose-800"><p class="font-semibold">Periksa kembali data imunisasi:</p><ul class="mt-1 list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>
    @endif
    <form method="POST" action="{{ isset($imunisasi) ? route('puskesmas.imunisasi.update', $imunisasi) : route('puskesmas.imunisasi.store') }}" class="space-y-4 rounded-xl bg-white p-5 shadow-sm sm:p-6">
        @csrf
        @if (isset($imunisasi)) @method('PUT') @endif
        <label class="block text-sm font-semibold text-gray-700">Peserta
            <select name="peserta_id" required class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                <option value="">Pilih peserta</option>
                @foreach ($peserta as $anggota)
                    <option value="{{ $anggota->id }}" @selected((string) old('peserta_id', $imunisasi->peserta_id ?? '') === (string) $anggota->id)>{{ $anggota->nama }} — {{ $anggota->label_kategori }} ({{ $anggota->keluarga->posyandu->nama_posyandu }})</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm font-semibold text-gray-700">Jenis imunisasi
            <input name="jenis_imunisasi" required maxlength="255" value="{{ old('jenis_imunisasi', $imunisasi->jenis_imunisasi ?? '') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
        </label>
        <div class="grid gap-4 sm:grid-cols-2">
            <label class="block text-sm font-semibold text-gray-700">Tanggal jadwal
                <input type="date" name="tanggal_jadwal" value="{{ old('tanggal_jadwal', isset($imunisasi) ? $imunisasi->tanggal_jadwal?->format('Y-m-d') : '') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
            </label>
            <label class="block text-sm font-semibold text-gray-700">Tanggal pemberian
                <input type="date" name="tanggal_pemberian" value="{{ old('tanggal_pemberian', isset($imunisasi) ? $imunisasi->tanggal_pemberian?->format('Y-m-d') : '') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
            </label>
        </div>
        <label class="block text-sm font-semibold text-gray-700">Status
            <select name="status" required class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                @foreach (['terjadwal' => 'Terjadwal', 'selesai' => 'Selesai', 'terlewat' => 'Terlewat'] as $value => $label)
                    <option value="{{ $value }}" @selected(old('status', $imunisasi->status ?? 'terjadwal') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </label>
        <label class="block text-sm font-semibold text-gray-700">Catatan
            <textarea name="catatan" rows="3" class="mt-1 w-full rounded-lg border-gray-300 text-sm">{{ old('catatan', $imunisasi->catatan ?? '') }}</textarea>
        </label>
        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('puskesmas.imunisasi.index') }}" class="rounded-lg border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">Batal</a>
            <button type="submit" class="rounded-lg bg-teal-700 px-5 py-2 text-sm font-bold text-white hover:bg-teal-800">Simpan Imunisasi</button>
        </div>
    </form>
</div>
@endsection
