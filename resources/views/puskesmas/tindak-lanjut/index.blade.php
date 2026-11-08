@extends('layouts.app')

@section('title', '— Tindak Lanjut Peserta')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tindak Lanjut Peserta</h1>
        <p class="mt-1 text-sm text-gray-500">Tinjau rujukan dari kader dan perbarui status tindak lanjut peserta pada wilayah Puskesmas.</p>
    </div>
    @if (session('success'))<div class="rounded-lg bg-emerald-50 p-3 text-sm font-medium text-emerald-800">{{ session('success') }}</div>@endif
    <div class="space-y-4">
        @forelse ($tindakLanjut as $item)
            @php($anggota = $item->pemeriksaan->peserta)
            <article class="rounded-xl bg-white p-5 shadow-sm">
                <div class="flex flex-wrap items-start justify-between gap-3">
                    <div>
                        <h2 class="font-bold text-gray-800">{{ $anggota->nama }} <span class="font-normal text-gray-500">· {{ $anggota->label_kategori }}</span></h2>
                        <p class="mt-1 text-xs text-gray-500">{{ $anggota->keluarga->posyandu->nama_posyandu }} · Diajukan {{ $item->tanggal_pengajuan?->format('d M Y') }}</p>
                        <p class="mt-3 text-sm text-gray-700">{{ $item->alasan_tindak_lanjut }}</p>
                    </div>
                    <a href="{{ route('puskesmas.peserta.show', $anggota) }}" class="text-sm font-semibold text-teal-700 hover:underline">Lihat KIA →</a>
                </div>
                <form method="POST" action="{{ route('puskesmas.tindak-lanjut.update', $item) }}" class="mt-5 grid gap-3 border-t border-gray-100 pt-4 sm:grid-cols-2 lg:grid-cols-4">
                    @csrf
                    @method('PUT')
                    <label class="text-xs font-semibold text-gray-600">Status
                        <select name="status" required class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                            @foreach (['diajukan' => 'Diajukan', 'diproses' => 'Diproses', 'selesai' => 'Selesai'] as $value => $label)
                                <option value="{{ $value }}" @selected($item->status === $value)>{{ $label }}</option>
                            @endforeach
                        </select>
                    </label>
                    <label class="text-xs font-semibold text-gray-600">Jenis tindak lanjut
                        <input name="jenis_tindak_lanjut" value="{{ $item->jenis_tindak_lanjut }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                    </label>
                    <label class="text-xs font-semibold text-gray-600">Tanggal tindak lanjut
                        <input type="date" name="tanggal_tindak_lanjut" value="{{ $item->tanggal_tindak_lanjut?->format('Y-m-d') }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                    </label>
                    <label class="text-xs font-semibold text-gray-600">Hasil
                        <input name="hasil_tindak_lanjut" value="{{ $item->hasil_tindak_lanjut }}" class="mt-1 w-full rounded-lg border-gray-300 text-sm">
                    </label>
                    <div class="sm:col-span-2 lg:col-span-4">
                        <button class="rounded-lg bg-teal-700 px-4 py-2 text-sm font-bold text-white hover:bg-teal-800">Simpan tindak lanjut</button>
                    </div>
                </form>
            </article>
        @empty
            <div class="rounded-xl bg-white p-8 text-center text-sm text-gray-500 shadow-sm">Belum ada pengajuan tindak lanjut dari kader.</div>
        @endforelse
    </div>
    @if ($tindakLanjut->hasPages()){{ $tindakLanjut->links() }}@endif
</div>
@endsection
