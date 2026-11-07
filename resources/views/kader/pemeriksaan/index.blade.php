<x-app-layout>
    <div class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER SECTION -->
            <div class="space-y-1">
                <h1 class="text-2xl font-black text-slate-800 tracking-tight">Siapa yang ingin diperiksa?</h1>
                <p class="text-xs text-slate-500 font-medium">Pilih peserta dari daftar atau gunakan pencarian untuk mencatat data medis mereka.</p>
            </div>

            <!-- SEARCH BAR & FILTER -->
            <div class="bg-white p-4 rounded-3xl border border-slate-200/80 shadow-xs space-y-4">
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </span>
                    <input type="text" placeholder="Cari nama peserta..." class="w-full pl-11 pr-4 py-2.5 text-xs rounded-2xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none transition-all">
                </div>

                <div class="flex items-center space-x-2 overflow-x-auto pb-1 text-xs">
                    <button class="px-4 py-2 rounded-xl bg-teal-700 text-white font-bold transition-all whitespace-nowrap">Semua</button>
                    <button class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-medium hover:bg-slate-200 transition-all whitespace-nowrap">Bayi & Balita (42)</button>
                    <button class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-medium hover:bg-slate-200 transition-all whitespace-nowrap">Ibu Hamil (24)</button>
                    <button class="px-4 py-2 rounded-xl bg-slate-100 text-slate-600 font-medium hover:bg-slate-200 transition-all whitespace-nowrap">Lansia (62)</button>
                </div>
            </div>

            <!-- DAFTAR PESERTA SIAP DIPERIKSA -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">

                <!-- Card 1: Balita Sinta -->
                <a href="{{ route('kader.pemeriksaan.create') }}?nama=Sinta&kategori=balita" class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden flex flex-col justify-between space-y-3 hover:border-teal-500 hover:shadow-md transition-all group">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-emerald-500"></div>
                    <div class="pl-2 flex items-start justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-700 flex items-center justify-center font-bold text-lg shrink-0">👶</div>
                            <div>
                                <h3 class="font-extrabold text-slate-800 text-sm group-hover:text-teal-700 transition-colors">Sinta</h3>
                                <p class="text-xs text-slate-500">2 Tahun 4 Bulan</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-teal-50 text-teal-700 border border-teal-100">Bayi & Balita</span>
                    </div>
                    <div class="pl-2 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>Pemeriksaan terakhir: 22 Ags 2026</span>
                        <span class="text-teal-700 font-bold group-hover:translate-x-1 transition-transform">Periksa &rarr;</span>
                    </div>
                </a>

                <!-- Card 2: Ibu Hamil Siti Aminah -->
                <a href="{{ route('kader.pemeriksaan.create') }}?nama=Siti%20Aminah&kategori=bumil" class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden flex flex-col justify-between space-y-3 hover:border-teal-500 hover:shadow-md transition-all group">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-amber-400"></div>
                    <div class="pl-2 flex items-start justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-2xl bg-rose-50 text-rose-700 flex items-center justify-center font-bold text-lg shrink-0">🤰</div>
                            <div>
                                <h3 class="font-extrabold text-slate-800 text-sm group-hover:text-teal-700 transition-colors">Siti Aminah</h3>
                                <p class="text-xs text-slate-500">Trimester 2 (24 minggu)</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 text-rose-700 border border-rose-100">Ibu Hamil</span>
                    </div>
                    <div class="pl-2 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>Pemeriksaan terakhir: 15 Ags 2026</span>
                        <span class="text-teal-700 font-bold group-hover:translate-x-1 transition-transform">Periksa &rarr;</span>
                    </div>
                </a>

                <!-- Card 3: Lansia Budi Santoso -->
                <a href="{{ route('kader.pemeriksaan.create') }}?nama=Budi%20Santoso&kategori=lansia" class="bg-white rounded-3xl p-5 border border-slate-200/80 shadow-xs relative overflow-hidden flex flex-col justify-between space-y-3 hover:border-teal-500 hover:shadow-md transition-all group">
                    <div class="absolute left-0 top-0 bottom-0 w-2 bg-rose-500"></div>
                    <div class="pl-2 flex items-start justify-between">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 rounded-2xl bg-blue-50 text-blue-700 flex items-center justify-center font-bold text-lg shrink-0">👵</div>
                            <div>
                                <h3 class="font-extrabold text-slate-800 text-sm group-hover:text-teal-700 transition-colors">Budi Santoso</h3>
                                <p class="text-xs text-slate-500">68 Tahun</p>
                            </div>
                        </div>
                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 text-blue-700 border border-blue-100">Lansia</span>
                    </div>
                    <div class="pl-2 pt-2 border-t border-slate-100 flex items-center justify-between text-xs text-slate-400">
                        <span>Pemeriksaan terakhir: 10 Ags 2026</span>
                        <span class="text-teal-700 font-bold group-hover:translate-x-1 transition-transform">Periksa &rarr;</span>
                    </div>
                </a>

            </div>

        </div>
    </div>
</x-app-layout>