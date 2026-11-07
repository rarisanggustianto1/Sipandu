@extends('layouts.app')

@section('title', '— Daftar Posyandu')

@section('content')
<div class="space-y-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold text-gray-800">Daftar Posyandu Binaan</h1>
        <a href="{{ route('puskesmas.posyandu.create') }}"
           class="rounded-md px-4 py-2 text-sm font-medium text-white bg-teal-500 hover:bg-teal-600 transition-colors">
            + Tambah Posyandu
        </a>
    </div>

    <div class="rounded-lg bg-white p-6 shadow">
        @if ($posyandu->isEmpty())
            <p class="text-sm text-gray-500">Belum ada Posyandu terdaftar.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase text-gray-500">
                            <th class="px-3 py-2">Nama Posyandu</th>
                            <th class="px-3 py-2">Alamat</th>
                            <th class="px-3 py-2">Kelurahan</th>
                            <th class="px-3 py-2">Kecamatan</th>
                            <th class="px-3 py-2">Telepon</th>
                            <th class="px-3 py-2">Pengaduan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($posyandu as $p)
                            <tr>
                                <td class="px-3 py-2 font-medium text-gray-800">{{ $p->nama_posyandu }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $p->alamat }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $p->kelurahan }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $p->kecamatan }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $p->telepon ?? '-' }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $p->total_pengaduan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

</div>
@endsection
