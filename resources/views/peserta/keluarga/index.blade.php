<x-app-layout>
    <div class="mx-auto max-w-6xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <p class="text-sm text-slate-500">Posyandu {{ $keluarga->posyandu->nama_posyandu }}</p>
                <h1 class="mt-1 text-2xl font-black text-slate-800">Keluarga {{ $keluarga->nama_kepala_keluarga }}</h1>
                <p class="mt-1 text-sm text-slate-600">No. KK {{ $keluarga->no_kk }} · {{ $keluarga->alamat }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('peserta.keluarga.edit', $keluarga) }}" class="rounded-xl bg-slate-100 px-4 py-3 text-sm font-semibold text-slate-700">Edit profil</a>
                <a href="{{ route('peserta.data.create') }}" class="rounded-xl bg-teal-700 px-4 py-3 text-sm font-bold text-white">Tambah anggota</a>
            </div>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <section class="grid gap-4 md:grid-cols-2">
            @forelse ($keluarga->peserta as $anggota)
                @php($pemeriksaanTerakhir = $anggota->pemeriksaanTerbaru)
                <article class="space-y-3 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div>
                        <h2 class="font-bold text-slate-800">{{ $anggota->nama }}</h2>
                        <p class="text-sm text-slate-500">{{ $anggota->label_kategori }} · {{ $anggota->jenis_kelamin === 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                    </div>
                    <div class="rounded-xl bg-slate-50 p-3 text-sm">
                        @if ($pemeriksaanTerakhir)
                            <p class="text-xs text-slate-500">Pemeriksaan terakhir · {{ $pemeriksaanTerakhir->tanggal_pemeriksaan?->format('d M Y') }}</p>
                            @if ($pemeriksaanTerakhir->balita)
                                <p class="mt-1">Berat {{ $pemeriksaanTerakhir->balita->berat_badan ?? '-' }} kg · {{ $pemeriksaanTerakhir->balita->catatan_gizi ?? '-' }}</p>
                            @elseif ($pemeriksaanTerakhir->bumil)
                                <p class="mt-1">{{ $pemeriksaanTerakhir->bumil->usia_kehamilan ?? '-' }} minggu · TD {{ $pemeriksaanTerakhir->bumil->tekanan_darah ?? '-' }}</p>
                            @elseif ($pemeriksaanTerakhir->lansia)
                                <p class="mt-1">TD {{ $pemeriksaanTerakhir->lansia->tekanan_darah ?? '-' }} · Berat {{ $pemeriksaanTerakhir->lansia->berat_badan ?? '-' }} kg</p>
                            @endif
                        @else
                            <p class="text-slate-500">Belum ada pemeriksaan.</p>
                        @endif
                    </div>
                    <a href="{{ route('peserta.data.show', $anggota) }}" class="inline-block text-sm font-semibold text-teal-800">Buka riwayat kesehatan →</a>
                </article>
            @empty
                <p class="rounded-2xl bg-white p-5 text-sm text-slate-500">Belum ada anggota keluarga terdaftar.</p>
            @endforelse
        </section>
    </div>
</x-app-layout>
