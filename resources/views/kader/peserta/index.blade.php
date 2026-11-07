<x-app-layout>
    <div x-data="{ 
        openTambah: false, 
        openDetail: false, 
        openKartu: false,
        activeTabFilter: 'semua',
        activeTabKartu: 'pertumbuhan',
        selectedPeserta: null
    }" class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. HEADER SECTION -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Data Peserta Posyandu</h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Kelola data Bayi & Balita, Ibu Hamil, dan Lansia Wilayah Mawar 01</p>
                </div>
                <button @click="openTambah = true" class="px-5 py-3 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs rounded-2xl shadow-md transition-all flex items-center space-x-2 self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Tambah Peserta Baru</span>
                </button>
            </div>

            <!-- 2. SEARCH BAR & FILTER TAB -->
            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" placeholder="Cari nama peserta atau NIK..." class="w-full pl-11 pr-4 py-2.5 text-xs rounded-2xl border border-slate-200 focus:ring-2 focus:ring-teal-500 focus:border-teal-500 outline-none transition-all">
                </div>

                <div class="flex items-center space-x-2 overflow-x-auto pb-1 text-xs">
                    <button @click="activeTabFilter = 'semua'" :class="activeTabFilter === 'semua' ? 'bg-teal-700 text-white font-bold' : 'bg-slate-100 text-slate-600 font-medium hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap">
                        Semua (128)
                    </button>
                    <button @click="activeTabFilter = 'balita'" :class="activeTabFilter === 'balita' ? 'bg-teal-700 text-white font-bold' : 'bg-slate-100 text-slate-600 font-medium hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap">
                        Bayi & Balita (42)
                    </button>
                    <button @click="activeTabFilter = 'bumil'" :class="activeTabFilter === 'bumil' ? 'bg-teal-700 text-white font-bold' : 'bg-slate-100 text-slate-600 font-medium hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap">
                        Ibu Hamil (24)
                    </button>
                    <button @click="activeTabFilter = 'lansia'" :class="activeTabFilter === 'lansia' ? 'bg-teal-700 text-white font-bold' : 'bg-slate-100 text-slate-600 font-medium hover:bg-slate-200'" class="px-4 py-2 rounded-xl transition-all whitespace-nowrap">
                        Lansia (62)
                    </button>
                </div>
            </div>

            <!-- 3. DAFTAR KARTU PESERTA -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                <!-- Card 1: Balita Sinta -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden flex flex-col justify-between space-y-4 hover:border-teal-300 transition-all">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-emerald-500"></div>
                    <div class="pl-2 space-y-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-lg shrink-0">👶</div>
                                <div>
                                    <h3 class="font-extrabold text-slate-800 text-sm">Sinta</h3>
                                    <p class="text-xs text-slate-500">2 Tahun 4 Bulan</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-100">Bayi & Balita</span>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-3 text-[11px] space-y-1 border border-slate-100">
                            <p class="text-slate-600"><strong>Pemeriksaan Terakhir:</strong> 22 Ags 2026</p>
                            <p class="text-emerald-700 font-semibold">Status: Perkembangan Baik</p>
                        </div>
                    </div>
                    <div class="pl-2 flex items-center gap-2 pt-2 border-t border-slate-100">
                        <button @click="openDetail = true; selectedPeserta = 'Sinta'" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all text-center">Detail</button>
                        <button @click="openKartu = true; selectedPeserta = 'Sinta'; activeTabKartu = 'pertumbuhan'" class="flex-1 py-2 bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold text-xs rounded-xl transition-all text-center">Kartu Health</button>
                    </div>
                </div>

                <!-- Card 2: Ibu Hamil Siti Aminah -->
                <div class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden flex flex-col justify-between space-y-4 hover:border-teal-300 transition-all">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-amber-400"></div>
                    <div class="pl-2 space-y-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center space-x-3">
                                <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center font-bold text-lg shrink-0">🤰</div>
                                <div>
                                    <h3 class="font-extrabold text-slate-800 text-sm">Siti Aminah</h3>
                                    <p class="text-xs text-slate-500">Trimester 2 (24 Minggu)</p>
                                </div>
                            </div>
                            <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100">Ibu Hamil</span>
                        </div>
                        <div class="bg-slate-50 rounded-2xl p-3 text-[11px] space-y-1 border border-slate-100">
                            <p class="text-slate-600"><strong>Pemeriksaan Terakhir:</strong> 15 Ags 2026</p>
                            <p class="text-amber-700 font-semibold">Status: LILA 21.5 cm (Risiko KEK)</p>
                        </div>
                    </div>
                    <div class="pl-2 flex items-center gap-2 pt-2 border-t border-slate-100">
                        <button @click="openDetail = true; selectedPeserta = 'Siti Aminah'" class="flex-1 py-2 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold text-xs rounded-xl transition-all text-center">Detail</button>
                        <button @click="openKartu = true; selectedPeserta = 'Siti Aminah'; activeTabKartu = 'pertumbuhan'" class="flex-1 py-2 bg-teal-50 hover:bg-teal-100 text-teal-800 font-bold text-xs rounded-xl transition-all text-center">Kartu Health</button>
                    </div>
                </div>

            </div>

            <!-- MODAL 1: DETAIL PESERTA (DENGAN INFORMASI TAMBAHAN & GRAFIK) -->
            <div x-show="openDetail" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-xs p-4 overflow-y-auto">
                <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-5 my-8 max-h-[90vh] overflow-y-auto">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <h3 class="font-extrabold text-base text-slate-800">Detail Peserta</h3>
                        <button @click="openDetail = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                    </div>

                    <!-- Header Profile Card -->
                    <div class="bg-gradient-to-r from-teal-800 to-emerald-700 text-white p-5 rounded-3xl space-y-2">
                        <div class="flex justify-between items-start">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-wider text-teal-200">Kategori Pasien</p>
                                <h2 class="text-xl font-black" x-text="selectedPeserta || 'Sinta'"></h2>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-white/20 text-white">Perkembangan Baik</span>
                        </div>
                        <div class="pt-2 flex justify-between text-xs text-teal-100 border-t border-white/20">
                            <span>2 Tahun 4 Bulan</span>
                            <span>Pemeriksaan Terakhir: 22 Ags 2026</span>
                        </div>
                    </div>

                    <!-- Ringkasan Kesehatan -->
                    <div class="space-y-2">
                        <h4 class="font-bold text-xs text-slate-800 uppercase tracking-wider">Ringkasan Kesehatan</h4>
                        <div class="grid grid-cols-2 gap-3 text-xs">
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-slate-400 text-[10px] uppercase font-bold">⌛ BB Terakhir</p>
                                <p class="text-base font-extrabold text-slate-800 mt-0.5">11.2 <span class="text-xs font-normal text-slate-500">kg</span></p>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-slate-400 text-[10px] uppercase font-bold">↕ Tinggi Badan</p>
                                <p class="text-base font-extrabold text-slate-800 mt-0.5">86 <span class="text-xs font-normal text-slate-500">cm</span></p>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-2xl border border-slate-100">
                                <p class="text-slate-400 text-[10px] uppercase font-bold">👶 Lingkar Kepala</p>
                                <p class="text-base font-extrabold text-slate-800 mt-0.5">48 <span class="text-xs font-normal text-slate-500">cm</span></p>
                            </div>
                            <div class="p-3 bg-emerald-50 rounded-2xl border border-emerald-100">
                                <p class="text-emerald-700 text-[10px] uppercase font-bold">💉 Imunisasi</p>
                                <p class="text-base font-extrabold text-emerald-800 mt-0.5">Lengkap</p>
                            </div>
                        </div>
                    </div>

                    <!-- Informasi Tambahan -->
                    <div class="space-y-2">
                        <h4 class="font-bold text-xs text-slate-800 uppercase tracking-wider">Informasi Tambahan</h4>
                        <div class="bg-slate-50/80 rounded-2xl p-4 border border-slate-100 space-y-3 text-xs">
                            <div>
                                <p class="text-[10px] font-bold text-slate-400 uppercase">NIK</p>
                                <p class="font-mono font-bold text-slate-800">327508XXXXXXXXXX</p>
                            </div>
                            <div class="border-t border-slate-200/60 pt-2">
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Tanggal Lahir</p>
                                <p class="font-bold text-slate-800">15 April 2024</p>
                            </div>
                            <div class="border-t border-slate-200/60 pt-2 grid grid-cols-2 gap-2">
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Nama Ibu</p>
                                    <p class="font-bold text-slate-800">Siti Aminah</p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold text-slate-400 uppercase">Nama Ayah</p>
                                    <p class="font-bold text-slate-800">Budi Santoso</p>
                                </div>
                            </div>
                            <div class="border-t border-slate-200/60 pt-2">
                                <p class="text-[10px] font-bold text-slate-400 uppercase">Alamat</p>
                                <p class="font-medium text-slate-700">Jl. Melati No. 45, RT 02/RW 05, Kelurahan Jatiwarna</p>
                            </div>
                        </div>
                    </div>

                    <!-- Grafik Berat Badan & Tombol Catat -->
                    <div class="space-y-3 pt-2">
                        <h4 class="font-bold text-xs text-slate-800 uppercase tracking-wider">Grafik Berat Badan</h4>
                        <div class="bg-teal-50/50 rounded-2xl p-4 border border-teal-100 h-28 flex items-end justify-between px-6 pb-2 relative">
                            <!-- Visual Simulasi Line Curve Grafik -->
                            <div class="absolute inset-x-6 top-8 bottom-8 border-b-2 border-teal-600 rounded-lg"></div>
                            <span class="text-[10px] font-bold text-teal-800 bg-white px-2 py-0.5 rounded shadow-xs relative z-10">Bln 24: 10.5kg</span>
                            <span class="text-[10px] font-bold text-teal-800 bg-white px-2 py-0.5 rounded shadow-xs relative z-10">Bln 26: 10.8kg</span>
                            <span class="text-[10px] font-bold text-teal-800 bg-white px-2 py-0.5 rounded shadow-xs relative z-10">Bln 28: 11.2kg</span>
                        </div>

                        <a href="{{ route('kader.pemeriksaan.index') }}" class="w-full py-3 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs rounded-2xl transition-all shadow-md text-center block">
                            + Catat Pemeriksaan Baru
                        </a>
                    </div>
                </div>
            </div>

            <!-- MODAL 2: KARTU KESEHATAN DIGITAL (2 TAB: PERTUMBUHAN & RIWAYAT) -->
            <div x-show="openKartu" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-xs p-4 overflow-y-auto">
                <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4 my-8 max-h-[90vh] overflow-y-auto">
                    
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <h3 class="font-extrabold text-base text-teal-800">Kartu Kesehatan</h3>
                        <button @click="openKartu = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                    </div>

                    <!-- Profile Header Card -->
                    <div class="bg-teal-50/80 p-4 rounded-2xl border border-teal-200 flex justify-between items-center">
                        <div>
                            <div class="flex items-center space-x-2">
                                <h3 class="font-black text-slate-800 text-base" x-text="selectedPeserta || 'Sinta'"></h3>
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-800">● Aktif</span>
                            </div>
                            <p class="text-xs text-slate-500 mt-0.5">👶 Bayi & Balita &nbsp;•&nbsp; 12 Bulan &nbsp;•&nbsp; ♀ Perempuan</p>
                        </div>
                    </div>

                    <!-- NAV TAB: PERTUMBUHAN & RIWAYAT -->
                    <div class="flex border-b border-slate-200">
                        <button @click="activeTabKartu = 'pertumbuhan'" :class="activeTabKartu === 'pertumbuhan' ? 'border-b-2 border-teal-700 text-teal-800 font-bold' : 'text-slate-400 font-medium hover:text-slate-600'" class="flex-1 py-2 text-center text-xs transition-all">
                            Pertumbuhan
                        </button>
                        <button @click="activeTabKartu = 'riwayat'" :class="activeTabKartu === 'riwayat' ? 'border-b-2 border-teal-700 text-teal-800 font-bold' : 'text-slate-400 font-medium hover:text-slate-600'" class="flex-1 py-2 text-center text-xs transition-all">
                            Riwayat
                        </button>
                    </div>

                    <!-- CONTENT TAB 1: PERTUMBUHAN -->
                    <div x-show="activeTabKartu === 'pertumbuhan'" class="space-y-4">
                        <!-- Banner Kurva WHO -->
                        <div class="p-3.5 bg-teal-50/60 rounded-2xl border border-teal-100 flex items-start space-x-3 text-xs text-teal-900">
                            <span class="text-base">💡</span>
                            <p class="leading-relaxed">
                                Pertumbuhan menunjukkan tren meningkat dan sesuai dengan kurva standar WHO.
                            </p>
                        </div>

                        <!-- Card Monitoring Stunting -->
                        <div class="p-4 bg-white rounded-2xl border border-slate-200 shadow-xs space-y-2">
                            <div class="flex justify-between items-center">
                                <h4 class="font-extrabold text-slate-800 text-xs">Monitoring Stunting</h4>
                                <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-slate-100 text-slate-700">Normal</span>
                            </div>
                            <div class="flex items-start space-x-3 pt-1">
                                <span class="w-6 h-6 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold text-xs shrink-0">✓</span>
                                <div>
                                    <p class="font-bold text-xs text-slate-800">Perkembangan Baik</p>
                                    <p class="text-[11px] text-slate-500 mt-0.5">Proporsi berat dan tinggi badan ideal. Lanjutkan pemberian nutrisi yang seimbang.</p>
                                </div>
                            </div>
                        </div>

                        <!-- Graph Cards: Berat Badan & Tinggi Badan -->
                        <div class="space-y-3 text-xs">
                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-slate-700">Berat Badan</span>
                                    <span class="px-2 py-0.5 bg-teal-100 text-teal-800 rounded font-bold text-[10px]">11.2 kg</span>
                                </div>
                                <div class="h-16 flex items-end justify-around text-[10px] text-slate-400 pt-2 border-b border-slate-200">
                                    <span>Jun (10kg)</span>
                                    <span>Jul (10.5kg)</span>
                                    <span class="font-bold text-teal-700">Aug (11.2kg)</span>
                                </div>
                            </div>

                            <div class="p-4 bg-slate-50 rounded-2xl border border-slate-100 space-y-2">
                                <div class="flex justify-between items-center">
                                    <span class="font-bold text-slate-700">Tinggi Badan</span>
                                    <span class="px-2 py-0.5 bg-teal-100 text-teal-800 rounded font-bold text-[10px]">86 cm</span>
                                </div>
                                <div class="h-16 flex items-end justify-around text-[10px] text-slate-400 pt-2 border-b border-slate-200">
                                    <span>Jun (83cm)</span>
                                    <span>Jul (84cm)</span>
                                    <span class="font-bold text-teal-700">Aug (86cm)</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- CONTENT TAB 2: RIWAYAT / TIMELINE REKAM KESEHATAN -->
                    <div x-show="activeTabKartu === 'riwayat'" class="space-y-4">
                        <h4 class="font-bold text-xs text-slate-800 uppercase tracking-wider">Timeline Rekam Kesehatan</h4>
                        
                        <div class="relative pl-6 space-y-4 border-l-2 border-teal-200">
                            <!-- Item Timeline 1 -->
                            <div class="relative space-y-2">
                                <span class="absolute -left-[31px] top-1 w-3.5 h-3.5 rounded-full bg-teal-600 ring-4 ring-teal-100"></span>
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-teal-100 text-teal-800">22 Agustus 2026</span>
                                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 text-xs space-y-2">
                                    <p class="font-bold text-slate-800">Pemeriksaan Posyandu</p>
                                    <div class="grid grid-cols-3 gap-2 text-[11px] bg-white p-2 rounded-xl border border-slate-100 text-center">
                                        <div><span class="text-slate-400 block text-[9px]">BB</span><strong>11.2 kg</strong></div>
                                        <div><span class="text-slate-400 block text-[9px]">TB</span><strong>86 cm</strong></div>
                                        <div><span class="text-slate-400 block text-[9px]">Lingkar</span><strong>48 cm</strong></div>
                                    </div>
                                    <p class="text-[11px] text-teal-800 bg-teal-50 p-2 rounded-xl border border-teal-100">ℹ️ "Pertumbuhan menunjukkan perkembangan yang baik."</p>
                                </div>
                            </div>

                            <!-- Item Timeline 2 -->
                            <div class="relative space-y-2">
                                <span class="absolute -left-[31px] top-1 w-3.5 h-3.5 rounded-full bg-slate-300"></span>
                                <span class="px-2.5 py-0.5 rounded-md text-[10px] font-bold bg-slate-100 text-slate-600">22 Juli 2026</span>
                                <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 text-xs space-y-2">
                                    <p class="font-bold text-slate-800">Pemeriksaan Posyandu</p>
                                    <div class="grid grid-cols-3 gap-2 text-[11px] bg-white p-2 rounded-xl border border-slate-100 text-center">
                                        <div><span class="text-slate-400 block text-[9px]">BB</span><strong>10.8 kg</strong></div>
                                        <div><span class="text-slate-400 block text-[9px]">TB</span><strong>84 cm</strong></div>
                                        <div><span class="text-slate-400 block text-[9px]">Lingkar</span><strong>47.5 cm</strong></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-2 border-t border-slate-100">
                        <button type="button" @click="openKartu = false" class="px-4 py-2 bg-slate-800 text-white rounded-xl font-bold text-xs">Tutup</button>
                    </div>
                </div>
            </div>

            <!-- MODAL 3: TAMBAH PESERTA BARU -->
            <div x-show="openTambah" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-xs p-4">
                <div class="bg-white rounded-3xl max-w-lg w-full p-6 shadow-2xl border border-slate-100 space-y-4">
                    <div class="flex justify-between items-center border-b border-slate-100 pb-3">
                        <h3 class="font-extrabold text-base text-slate-800">Tambah Peserta Posyandu</h3>
                        <button @click="openTambah = false" class="text-slate-400 hover:text-slate-600 text-xl font-bold">&times;</button>
                    </div>

                    <form class="space-y-3 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Nama Lengkap</label>
                            <input type="text" placeholder="Masukkan nama lengkap" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">NIK Peserta</label>
                                <input type="text" placeholder="16 Digit NIK" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                            </div>
                            <div>
                                <label class="block font-bold text-slate-700 mb-1">Kategori</label>
                                <select class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                                    <option>Bayi & Balita</option>
                                    <option>Ibu Hamil</option>
                                    <option>Lansia</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end space-x-2 pt-4 border-t border-slate-100">
                            <button type="button" @click="openTambah = false" class="px-4 py-2.5 bg-slate-100 hover:bg-slate-200 text-slate-600 rounded-xl font-bold">Batal</button>
                            <button type="button" @click="openTambah = false" class="px-4 py-2.5 bg-teal-700 hover:bg-teal-800 text-white rounded-xl font-bold shadow-xs">Simpan Peserta</button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>