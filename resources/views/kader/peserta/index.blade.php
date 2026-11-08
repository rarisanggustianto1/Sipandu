<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-col justify-between gap-4 sm:flex-row sm:items-center">
            <div>
                <h1 class="text-2xl font-black text-slate-800">Data Peserta Posyandu</h1>
                <p class="mt-1 text-sm text-slate-500">Peserta yang terdaftar di Posyandu Anda.</p>
            </div>
            <a href="{{ route('kader.peserta.create') }}" class="rounded-xl bg-teal-700 px-4 py-3 text-sm font-bold text-white hover:bg-teal-800">
                Tambah peserta / keluarga
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <form method="GET" action="{{ route('kader.peserta.index') }}" class="flex flex-col gap-3 rounded-2xl bg-white p-4 shadow-sm sm:flex-row">
            <input name="search" value="{{ request('search') }}" placeholder="Cari nama peserta" class="min-w-0 flex-1 rounded-xl border-slate-200 text-sm">
            <select name="kategori" class="rounded-xl border-slate-200 text-sm">
                <option value="">Semua kategori</option>
                <option value="balita" @selected(request('kategori') === 'balita')>Bayi / balita</option>
                <option value="ibu_hamil" @selected(request('kategori') === 'ibu_hamil')>Ibu hamil</option>
                <option value="lansia" @selected(request('kategori') === 'lansia')>Lansia</option>
            </select>
            <button class="rounded-xl bg-slate-800 px-5 py-2 text-sm font-bold text-white">Cari</button>
        </form>

        <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($peserta as $anggota)
                @php($pemeriksaanTerakhir = $anggota->pemeriksaanTerbaru)
                <article class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex items-start justify-between gap-3">
                        <div>
                            <h2 class="font-bold text-slate-800">{{ $anggota->nama }}</h2>
                            <p class="mt-1 text-xs text-slate-500">{{ $anggota->label_kategori }} · NIK {{ $anggota->nik }}</p>
                            <p class="mt-1 text-xs text-slate-500">Keluarga {{ $anggota->keluarga->nama_kepala_keluarga }}</p>
                        </div>
                        <span class="rounded-full bg-teal-50 px-3 py-1 text-xs font-semibold text-teal-800">{{ $anggota->keluarga->no_kk }}</span>
                    </div>

                    <div class="rounded-xl bg-slate-50 p-3 text-sm">
                        <p class="text-xs font-semibold uppercase text-slate-500">Pemeriksaan terakhir</p>
                        @if ($pemeriksaanTerakhir)
                            <p class="mt-1">{{ $pemeriksaanTerakhir->tanggal_pemeriksaan?->format('d M Y') }}</p>
                            @if ($pemeriksaanTerakhir->balita)
                                <p class="text-xs text-slate-600">Berat {{ $pemeriksaanTerakhir->balita->berat_badan ?? '-' }} kg · {{ $pemeriksaanTerakhir->balita->catatan_gizi ?? 'Status gizi belum diisi' }}</p>
                            @elseif ($pemeriksaanTerakhir->bumil)
                                <p class="text-xs text-slate-600">Kehamilan {{ $pemeriksaanTerakhir->bumil->usia_kehamilan ?? '-' }} minggu</p>
                            @elseif ($pemeriksaanTerakhir->lansia)
                                <p class="text-xs text-slate-600">Tekanan darah {{ $pemeriksaanTerakhir->lansia->tekanan_darah ?? '-' }}</p>
                            @endif
                        @else
                            <p class="mt-1 text-slate-500">Belum ada pemeriksaan.</p>
                        @endif
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('kader.pemeriksaan.create', ['peserta_id' => $anggota->id]) }}" class="flex-1 rounded-xl bg-teal-700 px-3 py-2 text-center text-xs font-bold text-white hover:bg-teal-800">Catat pemeriksaan</a>
                        <a href="{{ route('kader.peserta.show', $anggota) }}" class="flex-1 rounded-xl bg-slate-100 px-3 py-2 text-center text-xs font-bold text-slate-700 hover:bg-slate-200">Kartu kesehatan</a>
                    </div>
                </article>
            @empty
                <p class="rounded-2xl bg-white p-6 text-sm text-slate-500">Belum ada peserta pada Posyandu ini.</p>
            @endforelse
        </div>

        {{ $peserta->links() }}
    </div>
</x-app-layout>
