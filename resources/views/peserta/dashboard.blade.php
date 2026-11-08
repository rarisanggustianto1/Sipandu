<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-3xl bg-gradient-to-r from-teal-900 to-teal-700 p-6 text-white">
            <p class="text-sm text-teal-100">Beranda keluarga · {{ $keluarga->posyandu->nama_posyandu }}</p>
            <h1 class="mt-2 text-2xl font-black">Halo, {{ $keluarga->nama_kepala_keluarga }}</h1>
            <p class="mt-2 text-sm text-teal-50">Pantau pemeriksaan terbaru setiap anggota keluarga di sini.</p>
            <a href="{{ route('peserta.data.create') }}" class="mt-5 inline-block rounded-xl bg-white px-4 py-2 text-sm font-bold text-teal-900">Tambah anggota keluarga</a>
        </div>

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Anggota keluarga</p><p class="mt-2 text-3xl font-black">{{ $totalPeserta }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Bayi / balita</p><p class="mt-2 text-3xl font-black">{{ $totalBalita }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Ibu hamil</p><p class="mt-2 text-3xl font-black">{{ $totalIbuHamil }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Lansia</p><p class="mt-2 text-3xl font-black">{{ $totalLansia }}</p></div>
        </div>

        <section class="rounded-2xl border border-slate-200 bg-white p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                    <h2 class="font-bold text-slate-800">Jadwal Posyandu berikutnya</h2>
                    @if ($kegiatanBerikutnya)
                        <p class="mt-1 text-sm text-slate-600">{{ $kegiatanBerikutnya->nama_kegiatan }} · {{ $kegiatanBerikutnya->tanggal_kegiatan?->format('d M Y') }} · {{ $kegiatanBerikutnya->waktu_mulai }}</p>
                    @else
                        <p class="mt-1 text-sm text-slate-500">Belum ada jadwal mendatang.</p>
                    @endif
                </div>
                <a href="{{ route('peserta.keluarga.index') }}" class="text-sm font-semibold text-teal-800">Lihat keluarga →</a>
            </div>
        </section>

        <section class="space-y-3">
            <h2 class="font-bold text-slate-800">Anggota keluarga dan pemeriksaan terakhir</h2>
            @forelse ($pesertaTerbaru as $anggota)
                @php($pemeriksaanTerakhir = $anggota->pemeriksaanTerbaru)
                <a href="{{ route('peserta.data.show', $anggota) }}" class="block rounded-2xl border border-slate-200 bg-white p-4 hover:border-teal-400">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <div>
                            <p class="font-bold text-slate-800">{{ $anggota->nama }} <span class="font-normal text-slate-500">· {{ $anggota->label_kategori }}</span></p>
                            @if ($pemeriksaanTerakhir)
                                <p class="mt-1 text-sm text-slate-600">Pemeriksaan {{ $pemeriksaanTerakhir->tanggal_pemeriksaan?->format('d M Y') }}
                                    @if ($pemeriksaanTerakhir->balita) · Berat {{ $pemeriksaanTerakhir->balita->berat_badan ?? '-' }} kg
                                    @elseif ($pemeriksaanTerakhir->bumil) · Kehamilan {{ $pemeriksaanTerakhir->bumil->usia_kehamilan ?? '-' }} minggu
                                    @elseif ($pemeriksaanTerakhir->lansia) · TD {{ $pemeriksaanTerakhir->lansia->tekanan_darah ?? '-' }}
                                    @endif
                                </p>
                            @else
                                <p class="mt-1 text-sm text-slate-500">Belum ada pemeriksaan.</p>
                            @endif
                        </div>
                        <span class="text-sm font-semibold text-teal-800">Lihat riwayat →</span>
                    </div>
                </a>
            @empty
                <p class="rounded-2xl bg-white p-5 text-sm text-slate-500">Belum ada anggota keluarga. Tambahkan anggota untuk memulai pemantauan.</p>
            @endforelse
        </section>
    </div>
</x-app-layout>
