@extends('layouts.app')

@section('title', '— Daftar Pengaduan')

@section('content')
<div class="space-y-6">

    <h1 class="text-2xl font-bold text-gray-800">Daftar Pengaduan</h1>

    {{-- Filter --}}
    <form method="GET" action="{{ route('puskesmas.pengaduan.index') }}"
          class="flex flex-wrap items-end gap-3 rounded-lg bg-white p-4 shadow">
        <div>
            <label for="search" class="block text-xs font-medium text-gray-600">Cari Judul</label>
            <input type="text" name="search" id="search" value="{{ request('search') }}"
                   class="mt-1 rounded-md border-gray-300 text-sm shadow-sm">
        </div>
        <div>
            <label for="status" class="block text-xs font-medium text-gray-600">Status</label>
            <select name="status" id="status" class="mt-1 rounded-md border-gray-300 text-sm shadow-sm">
                <option value="">Semua</option>
                @foreach (\App\Http\Controllers\Puskesmas\PengaduanController::STATUS as $s)
                    <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="rounded-md px-4 py-2 text-sm font-medium text-white bg-rose-500 hover:bg-rose-600 transition-colors">Terapkan</button>
    </form>

    <div class="rounded-lg bg-white p-6 shadow">
        @if ($pengaduan->isEmpty())
            <p class="text-sm text-gray-500">Belum ada pengaduan masuk.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 text-sm">
                    <thead>
                        <tr class="text-left text-xs uppercase text-gray-500">
                            <th class="px-3 py-2">Judul</th>
                            <th class="px-3 py-2">Jenis</th>
                            <th class="px-3 py-2">Posyandu</th>
                            <th class="px-3 py-2">Pelapor</th>
                            <th class="px-3 py-2">Status</th>
                            <th class="px-3 py-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach ($pengaduan as $p)
                            <tr>
                                <td class="px-3 py-2 font-medium text-gray-800">{{ $p->judul }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $p->jenis }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $p->posyandu?->nama_posyandu }}</td>
                                <td class="px-3 py-2 text-gray-700">{{ $p->pelapor->name ?? '-' }}</td>
                                <td class="px-3 py-2">
                                    <x-puskesmas.status-badge :status="$p->status" />
                                </td>
                                <td class="px-3 py-2">
                                    <a href="{{ route('puskesmas.pengaduan.show', $p->id) }}"
                                       class="rounded px-3 py-1 text-xs font-medium text-white bg-teal-500 hover:bg-teal-600 transition-colors">Detail</a>
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