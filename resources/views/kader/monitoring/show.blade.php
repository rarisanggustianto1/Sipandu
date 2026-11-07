<x-app-layout>
    <div x-data="{ tabGrafik: 'bb' }" class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- TOMBOL KEMBALI & HEADER -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('kader.monitoring.index') }}" class="p-2.5 bg-white rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <div>
                    <h1 class="text-xl font-black text-slate-800 tracking-tight capitalize">
                        Monitoring {{ request('kategori', 'Ibu Hamil') == 'bumil' ? 'Ibu Hamil' : request('kategori') }}
                    </h1>
                    <p class="text-xs text-slate-500 font-medium">Ringkasan kondisi dan tren kesehatan peserta</p>
                </div>
            </div>

            <!-- 1. STATISTIK RINGKASAN KATEGORI (GRID 4 CARD) -->
            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                <div class="bg-white p-4 rounded-3xl border border-teal-300 shadow-xs">
                    <p class="text-[10px] font-bold uppercase text-teal-700">Total Peserta</p>
                    <h2 class="text-2xl font-black text-teal-800 mt-1">24</h2>
                </div>
                <div class="bg-white p-4 rounded-3xl border border-slate-200 shadow-xs">
                    <p class="text-[10px] font-bold uppercase text-slate-400">● Baik</p>
                    <h2 class="text-2xl font-black text-slate-800 mt-1">18</h2>
                </div>
                <div class="bg-white p-4 rounded-3xl border border-amber-200 shadow-xs">
                    <p class="text-[10px] font-bold uppercase text-amber-600">● Dipantau</p>
                    <h2 class="text-2xl font-black text-amber-700 mt-1">4</h2>
                </div>
                <div class="bg-white p-4 rounded-3xl border border-rose-200 shadow-xs">
                    <p class="text-[10px] font-bold uppercase text-rose-600">● Prioritas</p>
                    <h2 class="text-2xl font-black text-rose-700 mt-1">2</h2>
                </div>
            </div>

            <!-- 2. TREN PEMERIKSAAN & GRAFIK -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <div>
                    <h3 class="font-extrabold text-slate-800 text-sm">Tren Pemeriksaan</h3>
                    <p class="text-xs text-slate-400 mt-0.5">Perkembangan rata-rata kondisi peserta</p>
                </div>

                <!-- Tab Pilihan Grafik -->
                <div class="bg-slate-100 p-1 rounded-2xl flex items-center text-xs">
                    <button @click="tabGrafik = 'bb'" :class="tabGrafik === 'bb' ? 'bg-white text-teal-800 font-bold shadow-xs' : 'text-slate-500 font-medium'" class="flex-1 py-1.5 rounded-xl transition-all">
                        Berat Badan
                    </button>
                    <button @click="tabGrafik = 'td'" :class="tabGrafik === 'td' ? 'bg-white text-teal-800 font-bold shadow-xs' : 'text-slate-500 font-medium'" class="flex-1 py-1.5 rounded-xl transition-all">
                        Tekanan Darah
                    </button>
                    <button @click="tabGrafik = 'lila'" :class="tabGrafik === 'lila' ? 'bg-white text-teal-800 font-bold shadow-xs' : 'text-slate-500 font-medium'" class="flex-1 py-1.5 rounded-xl transition-all">
                        LILA
                    </button>
                </div>

                <!-- Area Visualisasi Grafik -->
                <div class="p-4 bg-teal-50/40 rounded-2xl border border-teal-100 h-36 flex items-end justify-between px-6 pb-2 relative">
                    <div class="absolute inset-x-6 top-8 bottom-8 border-b-2 border-teal-600 rounded-lg"></div>
                    <span class="text-[10px] font-bold text-teal-800 bg-white px-2 py-0.5 rounded shadow-xs relative z-10">Bln 1: 56.8kg</span>
                    <span class="text-[10px] font-bold text-teal-800 bg-white px-2 py-0.5 rounded shadow-xs relative z-10">Bln 2: 57.4kg</span>
                    <span class="text-[10px] font-bold text-teal-800 bg-white px-2 py-0.5 rounded shadow-xs relative z-10">Bln 3: 58.6kg</span>
                </div>
            </div>

            <!-- 3. DISTRIBUSI USIA KEHAMILAN -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-3">
                <h3 class="font-bold text-slate-800 text-sm">Distribusi Usia Kehamilan</h3>
                <div class="w-full h-3 bg-slate-100 rounded-full overflow-hidden flex">
                    <div class="bg-teal-300 h-full" style="width: 17%"></div>
                    <div class="bg-teal-500 h-full" style="width: 46%"></div>
                    <div class="bg-teal-800 h-full" style="width: 37%"></div>
                </div>
                <div class="flex items-center justify-around text-xs font-bold text-slate-600 pt-1">
                    <span class="flex items-center space-x-1"><span class="w-2.5 h-2.5 rounded-full bg-teal-300"></span><span>T1 (4)</span></span>
                    <span class="flex items-center space-x-1"><span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span><span>T2 (11)</span></span>
                    <span class="flex items-center space-x-1"><span class="w-2.5 h-2.5 rounded-full bg-teal-800"></span><span>T3 (9)</span></span>
                </div>
                <p class="text-[11px] text-slate-500 bg-slate-50 p-2.5 rounded-xl border border-slate-100">ℹ️ Mayoritas peserta berada pada trimester 2 dan 3.</p>
            </div>

            <!-- 4. MENDEKATI PERKIRAAN PERSALINAN (HPL) & PRIORITAS -->
            <div class="space-y-3">
                <h3 class="font-bold text-slate-800 text-sm">Mendekati Perkiraan Persalinan & Prioritas</h3>

                <div class="bg-white p-5 rounded-3xl border border-amber-200 shadow-xs space-y-3">
                    <div class="flex justify-between items-start">
                        <div class="flex items-center space-x-3">
                            <div class="w-10 h-10 rounded-2xl bg-amber-100 text-amber-800 font-bold flex items-center justify-center text-xs">RA</div>
                            <div>
                                <h4 class="font-bold text-slate-800 text-sm">Rina Anggraini</h4>
                                <p class="text-xs text-slate-500">HPL: 18 Sept 2026</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-800">Mendekati HPL</span>
                    </div>
                    <div class="space-y-1">
                        <div class="flex justify-between text-xs font-bold text-slate-600">
                            <span>Usia Kehamilan</span>
                            <span class="text-teal-700">36/40 Minggu</span>
                        </div>
                        <div class="w-full h-2 bg-slate-100 rounded-full overflow-hidden">
                            <div class="bg-teal-600 h-full" style="width: 90%"></div>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-5 rounded-3xl border border-rose-200 shadow-xs space-y-3">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-2xl bg-rose-100 text-rose-800 font-bold flex items-center justify-center text-xs">RA</div>
                        <div>
                            <h4 class="font-bold text-slate-800 text-sm">Rina Anggraini</h4>
                            <p class="text-xs font-bold text-rose-600">Tekanan Darah Tinggi</p>
                        </div>
                    </div>
                    <a href="{{ route('kader.peserta.index') }}" class="w-full py-2 bg-slate-50 hover:bg-slate-100 text-teal-800 border border-slate-200 font-bold text-xs rounded-xl block text-center">
                        Lihat Detail
                    </a>
                </div>
            </div>

            <!-- 5. KONDISI PEMERIKSAAN TERAKHIR, INSIGHT & REKOMENDASI -->
            <div class="space-y-4">
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-3">
                    <h3 class="font-bold text-slate-800 text-sm">Insight Monitoring</h3>
                    <ul class="space-y-2 text-xs text-slate-600">
                        <li class="flex items-start space-x-2">💡 <span>Peningkatan kasus Hipertensi pada trimester 3 bulan ini.</span></li>
                        <li class="flex items-start space-x-2">💡 <span>4 peserta belum melakukan kunjungan ANC rutin.</span></li>
                        <li class="flex items-start space-x-2">💡 <span>Rata-rata kenaikan berat badan peserta cukup baik.</span></li>
                    </ul>
                </div>

                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-3">
                    <h3 class="font-bold text-slate-800 text-sm">Rekomendasi Tindak Lanjut</h3>
                    <div class="space-y-2 text-xs">
                        <div class="p-3 bg-rose-50 rounded-2xl border border-rose-100 text-rose-800 font-medium">
                            🚨 <strong>Rujuk Rina Anggraini ke Puskesmas</strong> - Tekanan darah persisten tinggi mendekati HPL.
                        </div>
                        <div class="p-3 bg-amber-50 rounded-2xl border border-amber-100 text-amber-800 font-medium">
                            ⚠️ <strong>Jadwalkan Kunjungan Rumah Dewi Lestari</strong> - Pantau asupan nutrisi untuk kenaikan BB.
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>