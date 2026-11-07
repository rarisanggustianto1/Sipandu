@extends('layouts.app')

@section('title', '— Tambah Posyandu')

@section('content')
<div class="max-w-2xl space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">Form Pendaftaran Posyandu Baru</h1>

    <div class="rounded-lg bg-white p-6 shadow">
        <form method="POST" action="{{ route('puskesmas.posyandu.store') }}" class="space-y-4">
            @csrf

            <div>
                <label for="nama_posyandu" class="block text-sm font-medium text-gray-700">Nama Posyandu</label>
                <input type="text" name="nama_posyandu" id="nama_posyandu" required
                       value="{{ old('nama_posyandu') }}"
                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div>
                <label for="alamat" class="block text-sm font-medium text-gray-700">Alamat</label>
                <textarea name="alamat" id="alamat" rows="2" required
                          class="mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('alamat') }}</textarea>
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="kelurahan" class="block text-sm font-medium text-gray-700">Kelurahan</label>
                    <input type="text" name="kelurahan" id="kelurahan" required
                           value="{{ old('kelurahan') }}"
                           class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                </div>
                <div>
                    <label for="kecamatan" class="block text-sm font-medium text-gray-700">Kecamatan</label>
                    <input type="text" name="kecamatan" id="kecamatan" required
                           value="{{ old('kecamatan') }}"
                           class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                </div>
            </div>

            <div>
                <label for="telepon" class="block text-sm font-medium text-gray-700">Telepon (opsional)</label>
                <input type="text" name="telepon" id="telepon" value="{{ old('telepon') }}"
                       class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
            </div>

            <div class="flex gap-3">
                <button type="submit" class="rounded-md px-4 py-2 text-sm font-medium text-white bg-emerald-500 hover:bg-emerald-600 transition-colors">Simpan Posyandu</button>
                <a href="{{ route('puskesmas.posyandu.index') }}"
                   class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Batal</a>
            </div>
        </form>
    </div>

</div>
@endsection