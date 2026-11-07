@extends('layouts.app')

@section('title', '— Detail Pengaduan')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Detail Pengaduan</h1>
        <a href="{{ route('puskesmas.pengaduan.index') }}"
           class="rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">
            Kembali ke Daftar
        </a>
    </div>

    {{-- Detail --}}
    <div class="rounded-lg bg-white p-6 shadow">
        <h2 class="text-lg font-semibold text-gray-800">{{ $data->judul }}</h2>

        <dl class="mt-4 grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
            <div>
                <dt class="font-medium text-gray-600">Jenis</dt>
                <dd class="text-gray-800">{{ $data->jenis }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Status</dt>
                <dd><x-puskesmas.status-badge :status="$data->status" /></dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Posyandu</dt>
                <dd class="text-gray-800">{{ $data->posyandu?->nama_posyandu ?? '-' }}</dd>
            </div>
            <div>
                <dt class="font-medium text-gray-600">Pelapor</dt>
                <dd class="text-gray-800">{{ $data->pelapor->name ?? '-' }}</dd>
            </div>
        </dl>

        <div class="mt-4">
            <dt class="font-medium text-gray-600">Deskripsi</dt>
            <p class="mt-1 whitespace-pre-line text-sm text-gray-800">{{ $data->deskripsi }}</p>
        </div>

        @if ($data->tanggapan_puskesmas)
            <div class="mt-4 rounded bg-green-50 p-3">
                <dt class="font-medium text-green-700">Tanggapan Puskesmas</dt>
                <p class="mt-1 whitespace-pre-line text-sm text-green-900">{{ $data->tanggapan_puskesmas }}</p>
            </div>
        @endif
    </div>

    {{-- Form Tanggapan --}}
    @if ($data->status !== 'selesai')
        <div class="rounded-lg bg-white p-6 shadow">
            <h2 class="mb-4 text-lg font-semibold text-gray-800">Berikan Tanggapan</h2>

            <form method="POST" action="{{ route('puskesmas.pengaduan.update', $data->id) }}"
                  class="space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="tanggapan_puskesmas" class="block text-sm font-medium text-gray-700">
                        Tanggapan / Tindak Lanjut
                    </label>
                    <textarea name="tanggapan_puskesmas" id="tanggapan_puskesmas" rows="4" required
                              class="mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('tanggapan_puskesmas', $data->tanggapan_puskesmas) }}</textarea>
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Ubah Status</label>
                    <select name="status" id="status" class="mt-1 rounded-md border-gray-300 text-sm shadow-sm">
                        <option value="diproses" @selected($data->status === 'diproses')>Diproses</option>
                        <option value="selesai" @selected($data->status === 'selesai')>Selesai</option>
                    </select>
                </div>

                <button type="submit" class="rounded-md px-4 py-2 text-sm font-medium text-white bg-teal-500 hover:bg-teal-600 transition-colors">Kirim Tanggapan</button>
            </form>
        </div>
    @else
        <div class="rounded bg-green-100 px-4 py-2 text-sm text-green-800">
            Pengaduan ini sudah selesai dan tidak dapat diubah lagi.
        </div>
    @endif

</div>
@endsection