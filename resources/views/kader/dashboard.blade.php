<x-app-layout>
    <div class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- 1. BANNER HERO & GREETING -->
            <div class="bg-gradient-to-r from-teal-800 via-teal-700 to-emerald-700 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-teal-900/10 relative overflow-hidden">
                <!-- Ornamen Dekoratif Background -->
                <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
                <div class="absolute right-1/3 -top-12 w-32 h-32 bg-emerald-400/20 rounded-full blur-xl pointer-events-none"></div>

                <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                    <div class="space-y-2">
                        <div class="inline-flex items-center space-x-2 bg-white/15 backdrop-blur-md px-3 py-1 rounded-full text-xs font-semibold text-teal-100 border border-white/20">
                            <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                            <span>Posyandu Mawar 01 • Sektor 3</span>
                        </div>
                        <h1 class="text-2xl sm:text-3xl font-black tracking-tight">
                            Halo, {{ Auth::user()->name ?? 'Kader Posyandu' }}! 👋
                        </h1>
                        <p class="text-xs sm:text-sm text-teal-100 max-w-xl font-normal leading-relaxed">
                            Pantau kesehatan masyarakat, catat hasil timbang balita, dan kelola prioritas intervensi hari ini secara cepat.
                        </p>
                    </div>

                    <!-- Shortcut Aksi Utama di Hero Banner -->
                    <div class="flex items-center gap-3 shrink-0">
                        <a href="{{ route('kader.peserta.index') }}" class="px-4 py-3 bg-white text-teal-800 hover:bg-teal-50 font-bold text-xs rounded-2xl shadow-md transition-all flex items-center space-x-2">
                            <svg class="w-4 h-4 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            <span>Tambah Peserta</span>
                        </a>
                        <a href="{{ route('kader.pemeriksaan.index') }}" class="px-4 py-3 bg-emerald-500 hover:bg-emerald-600 text-white font-bold text-xs rounded-2xl shadow-md transition-all flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                            <span>Catat Periksa</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- 2. GRID STATISTIK PESERTA (LAYOUT DUAL ROW) -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                
                <!-- Total Keseluruhan -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Peserta</span>
                        <div class="p-2.5 bg-teal-50 text-teal-700 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-3xl font-black text-slate-800">128</h3>
                        <p class="text-[11px] text-teal-700 font-semibold mt-1">Aktif Terdaftar</p>
                    </div>
                </div>

                <!-- Bayi & Balita -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Bayi & Balita</span>
                        <div class="p-2.5 bg-amber-50 text-amber-600 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-3xl font-black text-slate-800">42 <span class="text-xs font-normal text-slate-400">Anak</span></h3>
                        <p class="text-[11px] text-amber-600 font-semibold mt-1">Usia 0 - 59 Bulan</p>
                    </div>
                </div>

                <!-- Ibu Hamil -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Ibu Hamil</span>
                        <div class="p-2.5 bg-rose-50 text-rose-600 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-3xl font-black text-slate-800">24 <span class="text-xs font-normal text-slate-400">Ibu</span></h3>
                        <p class="text-[11px] text-rose-600 font-semibold mt-1">Pendampingan Rutin</p>
                    </div>
                </div>

                <!-- Lansia -->
                <div class="bg-white p-5 rounded-3xl border border-slate-200/80 shadow-xs flex flex-col justify-between">
                    <div class="flex items-center justify-between">
                        <span class="text-xs font-bold text-slate-400 uppercase tracking-wider">Lansia</span>
                        <div class="p-2.5 bg-blue-50 text-blue-600 rounded-2xl">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h3 class="text-3xl font-black text-slate-800">62 <span class="text-xs font-normal text-slate-400">Orang</span></h3>
                        <p class="text-[11px] text-blue-600 font-semibold mt-1">Usia &ge; 60 Tahun</p>
                    </div>
                </div>

            </div>

            <!-- 3. KONTEN UTAMA: DUA KOLOM (STATISTIK KONDISI & TARGET SWEEPING) -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

                <!-- Kiri (2 Kolom): Status Kesehatan & Prioritas -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Card Ringkasan Status Kesehatan -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-extrabold text-slate-800 text-base">Status Kesehatan Peserta Bulan Ini</h3>
                                <p class="text-xs text-slate-400">Hasil pemantauan antropometri dan gizi terkini</p>
                            </div>
                            <span class="text-xs font-bold text-teal-800 bg-teal-50 px-3 py-1 rounded-full border border-teal-100">Oktober 2026</span>
                        </div>

                        <!-- Progress Line Interaktif -->
                        <div class="space-y-1.5">
                            <div class="w-full h-3.5 bg-slate-100 rounded-full overflow-hidden flex">
                                <div class="bg-emerald-500 h-full" style="width: 86%"></div>
                                <div class="bg-amber-400 h-full" style="width: 10%"></div>
                                <div class="bg-rose-500 h-full" style="width: 4%"></div>
                            </div>
                        </div>

                        <!-- Grid Persentase -->
                        <div class="grid grid-cols-3 gap-3">
                            <div class="p-3.5 rounded-2xl bg-emerald-50/50 border border-emerald-100 text-center">
                                <p class="text-[11px] font-bold text-emerald-800">Sesuai Kurva / Baik</p>
                                <p class="text-xl font-black text-emerald-700 mt-0.5">86%</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-amber-50/50 border border-amber-100 text-center">
                                <p class="text-[11px] font-bold text-amber-800">Perlu Pemantauan</p>
                                <p class="text-xl font-black text-amber-700 mt-0.5">10%</p>
                            </div>
                            <div class="p-3.5 rounded-2xl bg-rose-50/50 border border-rose-100 text-center">
                                <p class="text-[11px] font-bold text-rose-800">Intervensi / Rujukan</p>
                                <p class="text-xl font-black text-rose-700 mt-0.5">4%</p>
                            </div>
                        </div>
                    </div>

                    <!-- Card Kasus Prioritas / Risiko Stunting -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div class="flex items-center space-x-2">
                                <span class="w-3 h-3 rounded-full bg-rose-500 animate-ping"></span>
                                <h3 class="font-bold text-slate-800 text-sm">Perlu Perhatian Khusus Hari Ini</h3>
                            </div>
                            <span class="text-xs text-rose-600 font-bold bg-rose-50 px-2.5 py-1 rounded-lg">1 Anak Indikasi Stunting</span>
                        </div>

                        <div class="p-4 rounded-2xl bg-slate-50 border border-slate-200/60 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                            <div class="space-y-1">
                                <div class="flex items-center space-x-2">
                                    <span class="font-extrabold text-slate-800 text-sm">Budi Santoso</span>
                                    <span class="text-[10px] font-bold px-2 py-0.5 rounded bg-rose-100 text-rose-700">24 Bulan</span>
                                </div>
                                <p class="text-xs text-slate-500">
                                    <strong>Indikasi:</strong> Tinggi Badan &lt; -2 SD (Risiko Stunting) • BB Tidak Naik 2 Bulan.
                                </p>
                            </div>
                            <a href="{{ route('kader.peserta.index') }}" class="px-4 py-2 bg-rose-600 hover:bg-rose-700 text-white font-bold text-xs rounded-xl transition-all shadow-xs shrink-0 text-center">
                                Tinjau Profil
                            </a>
                        </div>
                    </div>

                </div>

                <!-- Kanan (1 Kolom): Informasi Agenda & Sweeping -->
                <div class="space-y-6">

                    <!-- Agenda Posyandu Terdekat -->
                    <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                        <h3 class="font-bold text-slate-800 text-sm border-b border-slate-100 pb-3">Jadwal Posyandu Berikutnya</h3>
                        
                        <div class="flex items-start space-x-3.5">
                            <div class="w-12 h-12 rounded-2xl bg-teal-100 text-teal-800 flex flex-col items-center justify-center shrink-0">
                                <span class="text-[10px] font-bold uppercase">Okt</span>
                                <span class="text-base font-black leading-none">15</span>
                            </div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Pelayanan Posyandu Rutin</h4>
                                <p class="text-xs text-slate-500 mt-0.5">Balai Desa Mawar • 08.00 - 11.00 WIB</p>
                                <span class="inline-block mt-2 text-[10px] font-bold text-teal-800 bg-teal-50 px-2.5 py-0.5 rounded-md border border-teal-100">Target: 24 Balita</span>
                            </div>
                        </div>
                    </div>

                    <!-- Alert Sweeping / Kunjungan Rumah -->
                    <div class="bg-emerald-800/5 rounded-3xl p-6 border border-teal-200/60 shadow-xs space-y-3">
                        <div class="flex items-center space-x-2 text-teal-900">
                            <svg class="w-5 h-5 text-teal-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                            <h4 class="font-bold text-sm">Kunjungan Rumah (Sweeping)</h4>
                        </div>
                        <p class="text-xs text-slate-600 leading-relaxed">
                            Terdapat <strong>4 Balita</strong> yang belum ditimbang pada penimbangan bulan ini. Lakukandampingan langsung ke rumah peserta.
                        </p>
                        <a href="{{ route('kader.peserta.index') }}" class="text-xs font-bold text-teal-800 hover:text-teal-900 hover:underline flex items-center space-x-1 pt-1">
                            <span>Lihat Daftar Peserta Sweeping</span>
                            <span>&rarr;</span>
                        </a>
                    </div>

                </div>

            </div>

        </div>
    </div>
</x-app-layout>