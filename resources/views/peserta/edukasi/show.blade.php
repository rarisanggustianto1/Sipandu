<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('peserta.edukasi.index') }}" 
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-teal-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
            <div class="h-5 w-px bg-gray-200"></div>
            <h2 class="font-bold text-xl text-teal-800 leading-tight">
                {{ __('Detail Materi Edukasi Kesehatan') }}
            </h2>
        </div>
    </x-slot>

    @php
        // Judul & data fallback jika membuka dummy artikel
        $dummyDetail = [
            'judul' => $edukasi->judul ?? 'Pentingnya Pemenuhan Gizi Seimbang 1000 Hari Pertama Kehidupan (HPK)',
            'kategori' => $edukasi->kategori ?? 'balita',
            'kategori_label' => match($edukasi->kategori ?? 'balita') {
                'balita' => 'Balita & Anak',
                'ibu_hamil' => 'Ibu Hamil',
                'lansia' => 'Lansia',
                default => 'Umum',
            },
            'tanggal' => isset($edukasi->tanggal_publikasi) ? \Carbon\Carbon::parse($edukasi->tanggal_publikasi)->translatedFormat('d F Y') : '12 Oktober 2026',
            'penulis' => 'Dinas Kesehatan Kab. Pesawaran',
            'gambar' => $edukasi->gambar ?? 'https://images.unsplash.com/photo-1544717305-2782549b5136?q=80&w=1200&auto=format&fit=crop',
            'isi' => $edukasi->isi ?? '
                <p class="mb-4">Seribu hari pertama kehidupan (1000 HPK) dimulai sejak terjadinya pembuahan di dalam rahim ibu hingga anak berusia 2 tahun (24 bulan). Periode ini sering disebut sebagai <strong>periode emas (golden period)</strong> karena pada masa inilah pertumbuhan dan perkembangan organ vital anak terjadi dengan sangat cepat.</p>
                <h4 class="text-lg font-bold text-gray-800 mt-6 mb-2">Mengapa 1000 HPK Sangat Krusial?</h4>
                <p class="mb-4">Kekurangan gizi pada periode ini bersifat permanen dan tidak dapat diperbaiki sepenuhnya di kemudian hari. Dampak dari kekurangan gizi meliputi hambatan pertumbuhan fisik (stunting), penurunan kecerdasan otak, hingga risiko menderita penyakit metabolik saat dewasa.</p>
                <h4 class="text-lg font-bold text-gray-800 mt-6 mb-2">Panduan Gizi dari Dinas Kesehatan:</h4>
                <ul class="list-disc pl-5 space-y-2 mb-4">
                    <li>Ibu hamil mengonsumsi makanan beragam dengan zat besi dan asam folat cukup.</li>
                    <li>Inisiasi Menyusu Dini (IMD) minimal 1 jam setelah persalinan.</li>
                    <li>Pemberian ASI Eksklusif selama 6 bulan pertama tanpa tambahan makanan/minuman apapun.</li>
                    <li>Pemberian Makanan Pendamping ASI (MPASI) bergizi seimbang mulai usia 6 bulan secara higienis.</li>
                    <li>Melakukan penimbangan berat badan dan pengukuran tinggi badan rutin setiap bulan di Posyandu.</li>
                </ul>
                <div class="bg-teal-50 border border-teal-200 rounded-xl p-4 text-teal-800 mt-6 text-sm">
                    <strong>Catatan Kader & Nakes:</strong> Bawa buku KIA setiap kali kunjungan posyandu untuk mencatat rekam perkembangan balita Anda secara berkala.
                </div>
            ',
        ];
    @endphp

    <div class="max-w-4xl mx-auto space-y-6">
        <article class="bg-white rounded-2xl border border-gray-200/80 shadow-sm overflow-hidden">
            <!-- Header Image -->
            <div class="relative h-64 sm:h-80 w-full overflow-hidden bg-gray-100">
                <img src="{{ $dummyDetail['gambar'] }}" alt="{{ $dummyDetail['judul'] }}" class="w-full h-full object-cover">
                <div class="absolute inset-0 bg-gradient-to-t from-gray-950/70 via-transparent to-transparent"></div>
                <div class="absolute bottom-6 left-6 right-6 text-white">
                    <span class="inline-block px-3 py-1 bg-teal-600 text-white rounded-full text-xs font-bold mb-2 shadow-sm">
                        {{ $dummyDetail['kategori_label'] }}
                    </span>
                    <h1 class="text-xl sm:text-2xl font-bold leading-tight">
                        {{ $dummyDetail['judul'] }}
                    </h1>
                </div>
            </div>

            <!-- Meta Information -->
            <div class="p-6 sm:p-8 space-y-6">
                <div class="flex flex-wrap items-center justify-between gap-4 pb-6 border-b border-gray-100 text-xs text-gray-500">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-xs border border-teal-200">
                            DK
                        </div>
                        <div>
                            <p class="font-semibold text-gray-800">{{ $dummyDetail['penulis'] }}</p>
                            <p class="text-[11px] text-gray-400">Publikasi Resmi Dinas Kesehatan</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span>Tanggal: <strong class="text-gray-700">{{ $dummyDetail['tanggal'] }}</strong></span>
                        <span class="bg-slate-100 text-slate-600 px-2.5 py-1 rounded-md text-[11px] font-medium">Hanya Melihat (Read-Only)</span>
                    </div>
                </div>

                <!-- Isi Artikel Edukasi -->
                <div class="prose max-w-none text-gray-700 text-sm leading-relaxed">
                    {!! $dummyDetail['isi'] !!}
                </div>

                <!-- Bagian Bawah Halaman -->
                <div class="pt-6 border-t border-gray-100 flex items-center justify-between">
                    <a href="{{ route('peserta.edukasi.index') }}" 
                       class="inline-flex items-center gap-2 text-xs font-semibold text-gray-600 hover:text-teal-700 transition-colors">
                        <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                        </svg>
                        <span>Kembali ke Semua Edukasi</span>
                    </a>
                    <span class="text-xs text-gray-400">SiPANDU • Modul Edukasi Peserta</span>
                </div>
            </div>
        </article>
    </div>
</x-app-layout>
