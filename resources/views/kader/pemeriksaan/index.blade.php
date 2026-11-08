<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <header>
            <h1 class="text-2xl font-black text-slate-900">Siapa yang ingin diperiksa?</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih peserta dari daftar atau gunakan pencarian untuk mencatat data medis mereka.</p>
        </header>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-800">{{ session('success') }}</div>
        @endif

        <section class="space-y-3 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <form method="GET" action="{{ route('kader.pemeriksaan.index') }}">
                @if ($kategoriTerpilih !== '')
                    <input type="hidden" name="kategori" value="{{ $kategoriTerpilih }}">
                @endif
                <div class="flex gap-2">
                    <label for="search-peserta" class="sr-only">Cari nama peserta</label>
                    <input
                        id="search-peserta"
                        type="search"
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari nama peserta..."
                        class="w-full rounded-xl border-slate-200 px-4 py-2.5 text-sm focus:border-teal-600 focus:ring-teal-600"
                    >
                    <button type="submit" class="rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-teal-800">
                        Cari
                    </button>
                </div>
                @error('search')
                    <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                @enderror
                @error('kategori')
                    <p class="mt-1 text-sm text-rose-700">{{ $message }}</p>
                @enderror
            </form>

            <nav aria-label="Filter kategori peserta" class="flex flex-wrap gap-2">
                @foreach ($kategoriOptions as $key => $label)
                    @php
                        $jumlah = $key === ''
                            ? array_sum($jumlahPerKategori->all())
                            : (int) ($jumlahPerKategori[$key] ?? 0);
                        $url = route('kader.pemeriksaan.index', array_filter([
                            'kategori' => $key,
                            'search' => $search,
                        ], fn ($value): bool => $value !== ''));
                        $aktif = $kategoriTerpilih === $key;
                    @endphp
                    <a
                        href="{{ $url }}"
                        @if ($aktif) aria-current="page" @endif
                        class="rounded-full px-3 py-1.5 text-xs font-semibold transition {{ $aktif ? 'bg-teal-700 text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}"
                    >{{ $label }} ({{ $jumlah }})</a>
                @endforeach
            </nav>
        </section>

        <section aria-label="Daftar peserta">
            @if ($peserta->isEmpty())
                <div class="rounded-2xl border border-slate-200 bg-white p-6 text-center">
                    <h2 class="font-bold text-slate-800">Peserta tidak ditemukan</h2>
                    <p class="mt-1 text-sm text-slate-500">Coba kata pencarian atau kategori yang berbeda.</p>
                </div>
            @else
                <div class="grid gap-3 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach ($peserta as $anggota)
                        <a
                            href="{{ route('kader.pemeriksaan.create', ['peserta_id' => $anggota->id]) }}"
                            class="group rounded-xl border border-slate-200 bg-white px-4 py-4 shadow-sm transition hover:border-teal-400 hover:bg-teal-50/40"
                        >
                            <span class="block font-bold text-slate-800 group-hover:text-teal-800">{{ $anggota->nama }}</span>
                            <span class="mt-1 block text-xs text-slate-500">
                                {{ $kategoriOptions[$anggota->kategori] }} · {{ $anggota->usia }} tahun
                                @if ($anggota->keluarga?->no_kk)
                                    · KK {{ $anggota->keluarga->no_kk }}
                                @endif
                            </span>
                            <span class="mt-3 inline-flex text-xs font-bold text-teal-700">Catat pemeriksaan</span>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4">{{ $peserta->links() }}</div>
            @endif
        </section>
    </div>
</x-app-layout>
