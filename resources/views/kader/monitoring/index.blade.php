<x-app-layout>
    <div x-data="{ range: 'bulan' }" class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER SECTION & FILTER RENTANG WAKTU -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Monitoring & Pemantauan</h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Pantau kondisi peserta dan tentukan prioritas tindak lanjut wilayah Mawar 01</p>
                </div>

                <!-- FILTER PILIHAN WAKTU -->
                <div class="bg-slate-200/60 p-1 rounded-2xl flex items-center text-xs self-start sm:self-auto">
                    <button @click="range = 'minggu'" :class="range === 'minggu' ? 'bg-teal-700 text-white font-bold shadow-xs' : 'text-slate-600 font-medium hover:text-slate-800'" class="px-3.5 py-1.5 rounded-xl transition-all">
                        Minggu Ini
                    </button>
                    <button @click="range = 'bulan'" :class="range === 'bulan' ? 'bg-teal-700 text-white font-bold shadow-xs' : 'text-slate-600 font-medium hover:text-slate-800'" class="px-3.5 py-1.5 rounded-xl transition-all">
                        Bulan Ini
                    </button>
                    <button @click="range = '3bulan'" :class="range === '3bulan' ? 'bg-teal-700 text-white font-bold shadow-xs' : 'text-slate-600 font-medium hover:text-slate-800'" class="px-3.5 py-1.5 rounded-xl transition-all">
                        3 Bulan
                    </button>
                </div>
            </div>

            <!-- 1. RINGKASAN POSYANDU CARD -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-wider">Total Peserta Dipantau</p>
                        <h2 class="text-3xl font-black text-slate-800 mt-1">128 <span class="text-xs font-normal text-slate-400">Jiwa</span></h2>
                    </div>
                    <span class="px-3 py-1 bg-emerald-50 text-emerald-700 border border-emerald-100 rounded-full text-xs font-bold flex items-center space-x-1">
                        <span>↗ +12%</span>
                        <span class="text-[10px] text-emerald-600 font-normal">kehadiran</span>
                    </span>
                </div>

                <!-- Multi-color Progress Bar -->
                <div class="space-y-1.5">
                    <div class="w-full h-3.5 bg-slate-100 rounded-full overflow-hidden flex">
                        <div class="bg-teal-600 h-full" style="width: 86%"></div>
                        <div class="bg-amber-500 h-full" style="width: 10%"></div>
                        <div class="bg-rose-500 h-full" style="width: 4%"></div>
                    </div>
                </div>

                <!-- Breakdown Status Stats -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-teal-600"></span>
                            <span class="text-xs font-medium text-slate-600">Kondisi Baik</span>
                        </div>
                        <span class="text-sm font-extrabold text-slate-800">86%</span>
                    </div>

                    <div class="p-3.5 bg-slate-50 rounded-2xl border border-slate-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-amber-500"></span>
                            <span class="text-xs font-medium text-slate-600">Perlu Pemantauan</span>
                        </div>
                        <span class="text-sm font-extrabold text-slate-800">10%</span>
                    </div>

                    <div class="p-3.5 bg-rose-50/50 rounded-2xl border border-rose-100 flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-rose-500"></span>
                            <span class="text-xs font-bold text-rose-700">Prioritas / Intervensi</span>
                        </div>
                        <span class="text-sm font-extrabold text-rose-700">4%</span>
                    </div>
                </div>
            </div>

            <!-- 2. BREAKDOWN PER KATEGORI MONITORING -->
            <!-- 2. BREAKDOWN PER KATEGORI MONITORING -->
            <div class="space-y-3">
                <h3 class="font-bold text-slate-800 text-sm">Kategori Monitoring (Klik untuk Lihat Detail)</h3>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                    <!-- Card Ibu Hamil (Bisa Di-klik) -->
                    <a href="{{ route('kader.monitoring.show', 'bumil') }}" class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs space-y-4 hover:border-teal-500 hover:shadow-md transition-all group block">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center font-bold text-base">🤰</div>
                                <div>
                                    <h4 class="font-extrabold text-slate-800 text-sm group-hover:text-teal-700 transition-colors">Ibu Hamil</h4>
                                    <p class="text-[11px] text-slate-400">Total 24 Orang</p>
                                </div>
                            </div>
                            <span class="text-teal-700 text-xs font-bold group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-center text-xs">
                            <div class="bg-teal-50/60 p-2.5 rounded-2xl border border-teal-100">
                                <span class="text-[10px] text-teal-700 font-bold block">Baik</span>
                                <span class="text-base font-black text-teal-800 mt-0.5 block">18</span>
                            </div>
                            <div class="bg-amber-50/60 p-2.5 rounded-2xl border border-amber-100">
                                <span class="text-[10px] text-amber-700 font-bold block">Dipantau</span>
                                <span class="text-base font-black text-amber-800 mt-0.5 block">5</span>
                            </div>
                            <div class="bg-rose-50/60 p-2.5 rounded-2xl border border-rose-100">
                                <span class="text-[10px] text-rose-700 font-bold block">Prioritas</span>
                                <span class="text-base font-black text-rose-800 mt-0.5 block">1</span>
                            </div>
                        </div>
                    </a>

                    <!-- Card Bayi & Balita (Bisa Di-klik) -->
                    <a href="{{ route('kader.monitoring.show', 'balita') }}" class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs space-y-4 hover:border-teal-500 hover:shadow-md transition-all group block">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-base">👶</div>
                                <div>
                                    <h4 class="font-extrabold text-slate-800 text-sm group-hover:text-teal-700 transition-colors">Bayi & Balita</h4>
                                    <p class="text-[11px] text-slate-400">Total 42 Anak</p>
                                </div>
                            </div>
                            <span class="text-teal-700 text-xs font-bold group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-center text-xs">
                            <div class="bg-teal-50/60 p-2.5 rounded-2xl border border-teal-100">
                                <span class="text-[10px] text-teal-700 font-bold block">Baik</span>
                                <span class="text-base font-black text-teal-800 mt-0.5 block">35</span>
                            </div>
                            <div class="bg-amber-50/60 p-2.5 rounded-2xl border border-amber-100">
                                <span class="text-[10px] text-amber-700 font-bold block">Dipantau</span>
                                <span class="text-base font-black text-amber-800 mt-0.5 block">5</span>
                            </div>
                            <div class="bg-rose-50/60 p-2.5 rounded-2xl border border-rose-100">
                                <span class="text-[10px] text-rose-700 font-bold block">Prioritas</span>
                                <span class="text-base font-black text-rose-800 mt-0.5 block">2</span>
                            </div>
                        </div>
                    </a>

                    <!-- Card Lansia (Bisa Di-klik) -->
                    <a href="{{ route('kader.monitoring.show', 'lansia') }}" class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs space-y-4 hover:border-teal-500 hover:shadow-md transition-all group block">
                        <div class="flex items-center justify-between border-b border-slate-100 pb-3">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-base">👵</div>
                                <div>
                                    <h4 class="font-extrabold text-slate-800 text-sm group-hover:text-teal-700 transition-colors">Lansia</h4>
                                    <p class="text-[11px] text-slate-400">Total 62 Orang</p>
                                </div>
                            </div>
                            <span class="text-teal-700 text-xs font-bold group-hover:translate-x-1 transition-transform">&rarr;</span>
                        </div>

                        <div class="grid grid-cols-3 gap-2 text-center text-xs">
                            <div class="bg-teal-50/60 p-2.5 rounded-2xl border border-teal-100">
                                <span class="text-[10px] text-teal-700 font-bold block">Baik</span>
                                <span class="text-base font-black text-teal-800 mt-0.5 block">52</span>
                            </div>
                            <div class="bg-amber-50/60 p-2.5 rounded-2xl border border-amber-100">
                                <span class="text-[10px] text-amber-700 font-bold block">Dipantau</span>
                                <span class="text-base font-black text-amber-800 mt-0.5 block">8</span>
                            </div>
                            <div class="bg-rose-50/60 p-2.5 rounded-2xl border border-rose-100">
                                <span class="text-[10px] text-rose-700 font-bold block">Prioritas</span>
                                <span class="text-base font-black text-rose-800 mt-0.5 block">2</span>
                            </div>
                        </div>
                    </a>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>