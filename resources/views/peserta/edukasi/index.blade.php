<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-2">
            <div>
                <h2 class="font-bold text-2xl text-teal-800 leading-tight">
                    {{ __('Edukasi & Informasi Kesehatan') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Pusat informasi dan panduan kesehatan terpercaya dari Dinas Kesehatan untuk balita, ibu hamil, dan lansia.
                </p>
            </div>
            <div class="inline-flex items-center gap-2 self-start md:self-auto bg-teal-50 text-teal-700 px-3 py-1.5 rounded-full text-xs font-semibold border border-teal-200/60">
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                <span>Sumber Resmi: Dinas Kesehatan</span>
            </div>
        </div>
    </x-slot>

    @php
        // Ambil filter kategori aktif dari request
        $activeCategory = request('kategori', 'semua');

        // Contoh Data Dummy apabila tabel database belum memiliki record edukasi
        $dummyArticles = [
            [
                'id' => 1,
                'judul' => 'Pentingnya Pemenuhan Gizi Seimbang 1000 Hari Pertama Kehidupan (HPK)',
                'kategori' => 'balita',
                'kategori_label' => 'Balita & Anak',
                'badge_color' => 'bg-teal-50 text-teal-700 border-teal-200',
                'ringkasan' => 'Seribu hari pertama kehidupan merupakan periode emas yang menentukan masa depan pertumbuhan fisik dan perkembangan otak buah hati Anda guna mencegah risiko stunting sedini mungkin.',
                'penulis' => 'Dinas Kesehatan Kab. Pesawaran',
                'tanggal' => '12 Oktober 2026',
                'gambar' => 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'id' => 2,
                'judul' => 'Jadwal Lengkap Imunisasi Dasar Lengkap (IDL) untuk Balita Sehat',
                'kategori' => 'balita',
                'kategori_label' => 'Balita & Anak',
                'badge_color' => 'bg-teal-50 text-teal-700 border-teal-200',
                'ringkasan' => 'Panduan jadwal pemberian vaksin polio, DPT-HB-Hib, PCV, dan Campak-Rubella secara gratis di posyandu terdekat untuk memperkuat kekebalan daya tahan tubuh anak.',
                'penulis' => 'Seksi Promkes & Pemberdayaan Masyarakat',
                'tanggal' => '08 Oktober 2026',
                'gambar' => 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'id' => 3,
                'judul' => 'Panduan Asupan Nutrisi dan Pantangan Makanan Ibu Hamil Trimester Pertama',
                'kategori' => 'ibu_hamil',
                'kategori_label' => 'Ibu Hamil',
                'badge_color' => 'bg-rose-50 text-rose-700 border-rose-200',
                'ringkasan' => 'Ketahui asupan asam folat, zat besi, kalsium, serta tips meredakan morning sickness pada masa awal kehamilan demi kesehatan janin dan calon ibu.',
                'penulis' => 'Dinas Kesehatan & Bidan Desa',
                'tanggal' => '02 Oktober 2026',
                'gambar' => 'https://images.unsplash.com/photo-1516549655169-df83a0774514?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'id' => 4,
                'judul' => 'Tanda Bahaya Kehamilan yang Wajib Diwaspadai Calon Ibu',
                'kategori' => 'ibu_hamil',
                'kategori_label' => 'Ibu Hamil',
                'badge_color' => 'bg-rose-50 text-rose-700 border-rose-200',
                'ringkasan' => 'Mengenali gejala pendarahan, nyeri ulu hati parah, bengkak wajah dan tangan, serta gerakan janin yang berkurang untuk tindakan medis cepat dan tepat.',
                'penulis' => 'Dinas Kesehatan Bidang KIA',
                'tanggal' => '25 September 2026',
                'gambar' => 'https://images.unsplash.com/photo-1584515979956-d9f6e5d09982?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'id' => 5,
                'judul' => 'Aktivitas Fisik Ringan & Senam Kebugaran Lansia di Posyandu Lansia',
                'kategori' => 'lansia',
                'kategori_label' => 'Lansia',
                'badge_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                'ringkasan' => 'Menjaga kekuatan sendi, keseimbangan tubuh, dan kesehatan kardiovaskular dengan gerakan aerobik ringan yang aman dan menyenangkan bagi usia senja.',
                'penulis' => 'Pokja Kesehatan Keluarga Dinkes',
                'tanggal' => '18 September 2026',
                'gambar' => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?q=80&w=600&auto=format&fit=crop',
            ],
            [
                'id' => 6,
                'judul' => 'Tips Mengelola Tekanan Darah & Gula Darah Tetap Stabil untuk Lansia',
                'kategori' => 'lansia',
                'kategori_label' => 'Lansia',
                'badge_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                'ringkasan' => 'Pola makan rendah garam, pembatasan gula olahan, dan pentingnya pemeriksaan rutin tensi darah setiap bulan di Posyandu Terintegrasi.',
                'penulis' => 'Dinas Kesehatan Kab. Pesawaran',
                'tanggal' => '10 September 2026',
                'gambar' => 'https://images.unsplash.com/photo-1505751172876-fa1923c5c528?q=80&w=600&auto=format&fit=crop',
            ],
        ];

        // Format data: gunakan dari database bila ada, atau fallback ke dummy
        if (isset($artikels) && count($artikels) > 0) {
            $listArticles = $artikels->map(function($item) {
                $categoryBadge = match($item->kategori) {
                    'balita' => ['label' => 'Balita & Anak', 'class' => 'bg-teal-50 text-teal-700 border-teal-200'],
                    'ibu_hamil' => ['label' => 'Ibu Hamil', 'class' => 'bg-rose-50 text-rose-700 border-rose-200'],
                    'lansia' => ['label' => 'Lansia', 'class' => 'bg-blue-50 text-blue-700 border-blue-200'],
                    default => ['label' => 'Umum', 'class' => 'bg-gray-50 text-gray-700 border-gray-200'],
                };

                return [
                    'id' => $item->id,
                    'judul' => $item->judul,
                    'kategori' => $item->kategori,
                    'kategori_label' => $categoryBadge['label'],
                    'badge_color' => $categoryBadge['class'],
                    'ringkasan' => \Illuminate\Support\Str::limit(strip_tags($item->isi), 120),
                    'penulis' => 'Dinas Kesehatan',
                    'tanggal' => $item->tanggal_publikasi ? \Carbon\Carbon::parse($item->tanggal_publikasi)->translatedFormat('d F Y') : \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y'),
                    'gambar' => $item->gambar ?? 'https://images.unsplash.com/photo-1576765608535-5f04d1e3f289?q=80&w=600&auto=format&fit=crop',
                ];
            });
        } else {
            // Filter dummy berdasarkan kategori bila filter aktif
            $listArticles = collect($dummyArticles);
            if ($activeCategory !== 'semua') {
                $listArticles = $listArticles->where('kategori', $activeCategory);
            }
        }
    @endphp

    <div class="space-y-6">

        <!-- ── Banner Sorotan / Edukasi Utama ────────────────────────── -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-800 to-teal-600 text-white p-6 sm:p-8 shadow-sm">
            <div class="relative z-10 max-w-2xl space-y-3">
                <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-teal-900/60 text-teal-200 text-xs font-semibold backdrop-blur-sm border border-teal-700/50">
                    <svg class="w-3.5 h-3.5 text-teal-300" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
                    </svg>
                    Pojok Informasi & Edukasi Warga
                </span>
                <h1 class="text-xl sm:text-2xl font-bold tracking-tight leading-snug">
                    Tingkatkan Pengetahuan Kesehatan Keluarga Bersama Posyandu
                </h1>
                <p class="text-sm text-teal-100 leading-relaxed">
                    Akses materi panduan MPASI, gizi seimbang, imunisasi berkala, pemeriksaan ibu hamil, dan pemantauan kesehatan lansia langsung dari Dinas Kesehatan.
                </p>
            </div>
            
            <!-- Dekorasi Lingkaran Halus -->
            <div class="absolute -right-10 -bottom-10 w-64 h-64 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            <div class="absolute right-12 top-6 w-32 h-32 rounded-full bg-teal-400/20 blur-xl pointer-events-none"></div>
        </div>

        <!-- ── Filter Tabs Kategori (Semua, Balita, Ibu Hamil, Lansia) ──── -->
        <div class="bg-white p-3 rounded-xl border border-gray-200/80 shadow-sm flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-1.5 overflow-x-auto py-1 max-w-full">
                <!-- Tab Semua -->
                <a href="{{ route('peserta.edukasi.index', ['kategori' => 'semua']) }}"
                   class="px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ $activeCategory === 'semua' ? 'bg-teal-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    Semua Kategori
                </a>

                <!-- Tab Balita & Anak -->
                <a href="{{ route('peserta.edukasi.index', ['kategori' => 'balita']) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ $activeCategory === 'balita' ? 'bg-teal-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <span class="w-2 h-2 rounded-full bg-teal-400"></span>
                    Balita & Anak
                </a>

                <!-- Tab Ibu Hamil -->
                <a href="{{ route('peserta.edukasi.index', ['kategori' => 'ibu_hamil']) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ $activeCategory === 'ibu_hamil' ? 'bg-teal-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <span class="w-2 h-2 rounded-full bg-rose-400"></span>
                    Ibu Hamil
                </a>

                <!-- Tab Lansia -->
                <a href="{{ route('peserta.edukasi.index', ['kategori' => 'lansia']) }}"
                   class="inline-flex items-center gap-1.5 px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ $activeCategory === 'lansia' ? 'bg-teal-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <span class="w-2 h-2 rounded-full bg-blue-400"></span>
                    Lansia
                </a>
            </div>

            <div class="text-xs text-gray-500 font-medium px-2">
                Menampilkan <span class="font-bold text-gray-800">{{ count($listArticles) }}</span> materi edukasi
            </div>
        </div>

        <!-- ── Grid Card Edukasi (Artikel & Materi Kesehatan) ──────────── -->
        @if (count($listArticles) > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($listArticles as $item)
                    <article class="bg-white rounded-xl border border-gray-200/80 overflow-hidden shadow-sm hover:shadow-md transition-all duration-200 flex flex-col group">
                        
                        <!-- Thumbnail Gambar -->
                        <div class="relative h-48 w-full overflow-hidden bg-gray-100">
                            <img src="{{ $item['gambar'] }}" 
                                 alt="{{ $item['judul'] }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            
                            <!-- Badge Kategori di Atas Gambar -->
                            <div class="absolute top-3 left-3">
                                <span class="inline-block px-2.5 py-1 text-[11px] font-bold rounded-lg border shadow-sm backdrop-blur-md {{ $item['badge_color'] }} bg-white/95">
                                    {{ $item['kategori_label'] }}
                                </span>
                            </div>
                        </div>

                        <!-- Konten Card -->
                        <div class="p-5 flex-1 flex flex-col justify-between">
                            <div class="space-y-2.5">
                                <!-- Info Tanggal & Penulis -->
                                <div class="flex items-center justify-between text-[11px] text-gray-400 font-medium">
                                    <span class="flex items-center gap-1 truncate max-w-[60%]">
                                        <svg class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 21a9.004 9.004 0 0 0 8.716-6.747M12 21a9.004 9.004 0 0 1-8.716-6.747M12 21c2.485 0 4.5-4.03 4.5-9S14.485 3 12 3m0 18c-2.485 0-4.5-4.03-4.5-9S9.515 3 12 3m0 0a8.997 8.997 0 0 1 7.843 4.582M12 3a8.997 8.997 0 0 0-7.843 4.582m15.686 0A11.953 11.953 0 0 1 12 10.5c-2.998 0-5.74-1.1-7.843-2.918m15.686 0A8.959 8.959 0 0 1 21 12c0 .778-.099 1.533-.284 2.253m0 0A17.919 17.919 0 0 1 12 16.5c-3.162 0-6.133-.815-8.716-2.247m0 0A9.015 9.015 0 0 1 3 12c0-1.605.42-3.113 1.157-4.418" />
                                        </svg>
                                        {{ $item['penulis'] }}
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.253M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                        </svg>
                                        {{ $item['tanggal'] }}
                                    </span>
                                </div>

                                <!-- Judul Artikel -->
                                <h3 class="text-base font-bold text-gray-800 leading-snug line-clamp-2 group-hover:text-teal-700 transition-colors">
                                    <a href="{{ route('peserta.edukasi.show', $item['id']) }}">
                                        {{ $item['judul'] }}
                                    </a>
                                </h3>

                                <!-- Ringkasan Singkat (Excerpt) -->
                                <p class="text-xs text-gray-500 leading-relaxed line-clamp-3">
                                    {{ $item['ringkasan'] }}
                                </p>
                            </div>

                            <!-- Tombol Aksi "Baca Selengkapnya" -->
                            <div class="pt-4 mt-4 border-t border-gray-100 flex items-center justify-between">
                                <span class="text-[11px] font-medium text-gray-400">Read-Only</span>
                                <a href="{{ route('peserta.edukasi.show', $item['id']) }}" 
                                   class="inline-flex items-center gap-1.5 text-xs font-semibold text-teal-700 hover:text-teal-900 group-hover:translate-x-0.5 transition-transform">
                                    <span>Baca Selengkapnya</span>
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                    </svg>
                                </a>
                            </div>
                        </div>

                    </article>
                @endforeach
            </div>

            <!-- Pagination jika data bersumber riil dari database Dinas -->
            @if (isset($artikels) && method_exists($artikels, 'links'))
                <div class="mt-6">
                    {{ $artikels->withQueryString()->links() }}
                </div>
            @endif
        @else
            <!-- State Kosong / Belum Ada Artikel -->
            <div class="bg-white rounded-xl border border-gray-200/80 p-12 text-center shadow-sm">
                <div class="w-16 h-16 rounded-full bg-teal-50 text-teal-600 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 0 1 6-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0 0 18 18a8.967 8.967 0 0 0-6 2.292m0-14.25v14.25" />
                    </svg>
                </div>
                <h4 class="text-base font-bold text-gray-800">Belum Ada Materi untuk Kategori Ini</h4>
                <p class="text-xs text-gray-500 mt-1 max-w-sm mx-auto">
                    Materi edukasi kesehatan untuk kategori ini sedang disiapkan oleh tim Dinas Kesehatan.
                </p>
                <a href="{{ route('peserta.edukasi.index') }}" 
                   class="inline-block mt-4 px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                    Lihat Semua Materi
                </a>
            </div>
        @endif

    </div>
</x-app-layout>
