@extends('layouts.app')

@section('title', '— Data Peserta & KIA')

@section('content')
<div class="mx-auto max-w-7xl space-y-6">
    <div>
        @if (request()->routeIs('puskesmas.monitoring.*'))
            <h1 class="text-2xl font-bold text-gray-800">Monitoring Perkembangan Peserta</h1>
            <p class="mt-1 text-sm text-gray-500">Pantau hasil pemeriksaan terbaru peserta dari seluruh Posyandu di wilayah Anda.</p>
        @else
            <h1 class="text-2xl font-bold text-gray-800">Data Peserta & Kartu KIA</h1>
            <p class="mt-1 text-sm text-gray-500">Peserta dari seluruh Posyandu di wilayah Puskesmas Anda.</p>
        @endif
    </div>

    <form method="GET" action="{{ route('puskesmas.peserta.index') }}" class="flex flex-col gap-3 rounded-xl bg-white p-4 shadow-sm sm:flex-row">
        <input name="search" value="{{ request('search') }}" placeholder="Cari nama peserta" class="min-w-0 flex-1 rounded-lg border-gray-300 text-sm">
        <select name="kategori" class="rounded-lg border-gray-300 text-sm">
            <option value="">Semua kategori</option>
            <option value="balita" @selected(request('kategori') === 'balita')>Bayi / balita</option>
            <option value="ibu_hamil" @selected(request('kategori') === 'ibu_hamil')>Ibu hamil</option>
            <option value="lansia" @selected(request('kategori') === 'lansia')>Lansia</option>
        </select>
        <button type="submit" class="rounded-lg bg-teal-700 px-5 py-2 text-sm font-bold text-white hover:bg-teal-800">Cari peserta</button>
    </form>

    <div class="overflow-hidden rounded-xl bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 text-sm">
                <thead class="bg-gray-50 text-left text-xs uppercase tracking-wide text-gray-500">
                    <tr>
                        <th class="px-5 py-3">Nama Peserta</th>
                        <th class="px-5 py-3">Kategori</th>
                        <th class="px-5 py-3">Posyandu</th>
                        <th class="px-5 py-3">Perkembangan Terbaru</th>
                        <th class="px-5 py-3">Pemeriksaan Terakhir</th>
                        <th class="px-5 py-3">Kartu Kesehatan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($peserta as $anggota)
                        @php($pemeriksaan = $anggota->pemeriksaanTerbaru)
                        <tr>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-gray-800">{{ $anggota->nama }}</p>
                                <p class="mt-0.5 text-xs text-gray-500">KK {{ $anggota->keluarga->no_kk }}</p>
                            </td>
                            <td class="px-5 py-4 text-gray-600">{{ $anggota->label_kategori }}</td>
                            <td class="px-5 py-4 text-gray-600">{{ $anggota->keluarga->posyandu->nama_posyandu }}</td>
                            <td class="px-5 py-4 text-gray-600">
                                @if ($pemeriksaan?->balita)
                                    <p>BB {{ $pemeriksaan->balita->berat_badan ?? '-' }} kg · TB {{ $pemeriksaan->balita->tinggi_badan ?? '-' }} cm</p>
                                    <p class="mt-0.5 text-xs text-gray-500">{{ $pemeriksaan->balita->catatan_gizi ?? 'Catatan gizi belum tersedia' }}</p>
                                @elseif ($pemeriksaan?->bumil)
                                    <p>Kehamilan {{ $pemeriksaan->bumil->usia_kehamilan ?? '-' }} minggu</p>
                                    <p class="mt-0.5 text-xs text-gray-500">Tekanan darah {{ $pemeriksaan->bumil->tekanan_darah ?? '-' }}</p>
                                @elseif ($pemeriksaan?->lansia)
                                    <p>Tekanan darah {{ $pemeriksaan->lansia->tekanan_darah ?? '-' }}</p>
                                    <p class="mt-0.5 text-xs text-gray-500">Berat {{ $pemeriksaan->lansia->berat_badan ?? '-' }} kg</p>
                                @else
                                    <span class="text-gray-400">Belum ada hasil pemeriksaan</span>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-gray-600">{{ $pemeriksaan?->tanggal_pemeriksaan?->format('d M Y') ?? 'Belum diperiksa' }}</td>
                            <td class="px-5 py-4">
                                <a href="{{ route('puskesmas.peserta.show', $anggota) }}" class="font-semibold text-teal-700 hover:text-teal-900 hover:underline">
                                    Lihat KIA →
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-gray-500">Belum ada peserta atau hasil pencarian tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($peserta->hasPages())
            <div class="border-t border-gray-100 px-5 py-3">{{ $peserta->links() }}</div>
        @endif
    </div>
</div>
@endsection
