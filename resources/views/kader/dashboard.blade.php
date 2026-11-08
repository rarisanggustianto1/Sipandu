<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <section class="flex flex-col justify-between gap-4 rounded-3xl bg-gradient-to-r from-teal-900 to-emerald-700 p-6 text-white sm:flex-row sm:items-center">
            <div>
                <p class="text-sm text-teal-100">{{ $namaPosyandu }}</p>
                <h1 class="mt-1 text-2xl font-black">Halo, {{ auth()->user()->name }}</h1>
                <p class="mt-2 text-sm text-teal-50">Data di halaman ini hanya mencakup Posyandu Anda.</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('kader.peserta.create') }}" class="rounded-xl bg-white px-4 py-3 text-sm font-bold text-teal-900">Tambah peserta</a>
                <a href="{{ route('kader.pemeriksaan.index') }}" class="rounded-xl bg-emerald-500 px-4 py-3 text-sm font-bold text-white">Catat pemeriksaan</a>
            </div>
        </section>

        <section class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
            <div class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Total peserta</p><p class="mt-2 text-3xl font-black text-slate-800">{{ $totalPeserta }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Bayi / balita</p><p class="mt-2 text-3xl font-black text-slate-800">{{ $totalBalita }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Ibu hamil</p><p class="mt-2 text-3xl font-black text-slate-800">{{ $totalBumil }}</p></div>
            <div class="rounded-2xl bg-white p-5 shadow-sm"><p class="text-sm text-slate-500">Lansia</p><p class="mt-2 text-3xl font-black text-slate-800">{{ $totalLansia }}</p></div>
        </section>

        <section class="rounded-2xl border border-slate-200 bg-white p-5">
            <h2 class="font-bold text-slate-800">Jadwal Posyandu berikutnya</h2>
            @if ($kegiatanBerikutnya)
                <p class="mt-2 text-sm text-slate-600">{{ $kegiatanBerikutnya->nama_kegiatan }} · {{ $kegiatanBerikutnya->tanggal_kegiatan?->format('d M Y') }} · {{ $kegiatanBerikutnya->waktu_mulai }}</p>
                <a href="{{ route('kader.jadwal.show', $kegiatanBerikutnya) }}" class="mt-3 inline-flex rounded-lg bg-teal-700 px-4 py-2 text-sm font-bold text-white hover:bg-teal-800">
                    {{ $kegiatanBerikutnya->status === 'berlangsung' ? 'Buka pertemuan aktif' : 'Lihat jadwal' }}
                </a>
            @else
                <p class="mt-2 text-sm text-slate-500">Belum ada jadwal mendatang.</p>
            @endif
        </section>

        <section class="space-y-3">
            <h2 class="font-bold text-slate-800">Pemeriksaan terbaru</h2>
            @forelse ($pemeriksaanTerbaru as $item)
                <a href="{{ route('kader.pemeriksaan.show', $item) }}" class="block rounded-2xl border border-slate-200 bg-white p-4 hover:border-teal-400">
                    <div class="flex flex-wrap justify-between gap-2">
                        <div>
                            <p class="font-bold text-slate-800">{{ $item->peserta->nama }} · {{ $item->peserta->label_kategori }}</p>
                            <p class="mt-1 text-sm text-slate-500">{{ $item->tanggal_pemeriksaan?->format('d M Y') }}</p>
                        </div>
                        @if ($item->balita)
                            <span class="text-sm text-slate-600">Berat {{ $item->balita->berat_badan ?? '-' }} kg · {{ $item->balita->catatan_gizi ?? '-' }}</span>
                        @elseif ($item->bumil)
                            <span class="text-sm text-slate-600">{{ $item->bumil->usia_kehamilan ?? '-' }} minggu · TD {{ $item->bumil->tekanan_darah ?? '-' }}</span>
                        @elseif ($item->lansia)
                            <span class="text-sm text-slate-600">TD {{ $item->lansia->tekanan_darah ?? '-' }} · Berat {{ $item->lansia->berat_badan ?? '-' }} kg</span>
                        @endif
                    </div>
                </a>
            @empty
                <p class="rounded-2xl bg-white p-5 text-sm text-slate-500">Belum ada pemeriksaan.</p>
            @endforelse
        </section>
    </div>
</x-app-layout>
