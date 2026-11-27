<x-app-layout>
    <div class="mx-auto max-w-6xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <header class="sticky top-0 z-10 -mx-4 -mt-8 border-b border-slate-200 bg-slate-50/95 px-4 py-4 backdrop-blur sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
            <h1 class="text-2xl font-black text-slate-800">Rekam medis keluarga</h1>
            <p class="mt-1 text-sm text-slate-500">Riwayat pemeriksaan terbaru untuk anggota keluarga Anda.</p>
        </header>

        <div class="grid gap-4 md:grid-cols-2">
            @forelse ($peserta as $anggota)
                @php($pemeriksaanTerakhir = $anggota->pemeriksaanTerbaru)
                <a href="{{ route('peserta.data.show', $anggota) }}" class="space-y-3 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm hover:border-teal-400">
                    <div>
                        <h2 class="font-bold text-slate-800">{{ $anggota->nama }}</h2>
                        <p class="text-sm text-slate-500">{{ $anggota->label_kategori }} · NIK {{ $anggota->nik }}</p>
                    </div>
                    @if ($pemeriksaanTerakhir)
                        <p class="rounded-xl bg-slate-50 p-3 text-sm text-slate-700">
                            Terakhir diperiksa {{ $pemeriksaanTerakhir->tanggal_pemeriksaan?->format('d M Y') }}
                            @if ($pemeriksaanTerakhir->balita) · Berat {{ $pemeriksaanTerakhir->balita->berat_badan ?? '-' }} kg
                            @elseif ($pemeriksaanTerakhir->bumil) · Usia kehamilan {{ $pemeriksaanTerakhir->bumil->usia_kehamilan ?? '-' }} minggu
                            @elseif ($pemeriksaanTerakhir->lansia) · Tekanan darah {{ $pemeriksaanTerakhir->lansia->tekanan_darah ?? '-' }}
                            @endif
                        </p>
                    @else
                        <p class="rounded-xl bg-slate-50 p-3 text-sm text-slate-500">Belum ada pemeriksaan.</p>
                    @endif
                </a>
            @empty
                <p class="rounded-2xl bg-white p-6 text-sm text-slate-500">Belum ada data anggota keluarga untuk ditampilkan.</p>
            @endforelse
        </div>

        {{ $peserta->links() }}
    </div>
</x-app-layout>
