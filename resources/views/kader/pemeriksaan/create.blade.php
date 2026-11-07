<x-app-layout>
    <div class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- BUTTON KEMBALI & HEADER -->
            <div class="flex items-center space-x-3">
                <a href="{{ route('kader.pemeriksaan.index') }}" class="p-2.5 bg-white rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Form Pemeriksaan Routine</h1>
            </div>

            <!-- PROFILE CARD PESERTA YANG DIPILIH -->
            <div class="bg-gradient-to-r from-teal-800 to-emerald-700 rounded-3xl p-6 text-white shadow-md flex items-center space-x-4">
                <div class="w-14 h-14 rounded-2xl bg-white/15 backdrop-blur-md flex items-center justify-center text-2xl shrink-0">
                    👶
                </div>
                <div>
                    <h2 class="text-xl font-extrabold">{{ request('nama', 'Sinta') }}</h2>
                    <p class="text-xs text-teal-100 font-medium">Catat data kesehatan rutin untuk balita ini.</p>
                </div>
            </div>

            <!-- FORM INPUT PEMERIKSAAN -->
            <form action="{{ route('kader.pemeriksaan.index') }}" method="GET" class="space-y-5">
                
                <!-- 1. INFORMASI KUNJUNGAN -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center space-x-2 text-teal-800 border-b border-slate-100 pb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <h3 class="font-extrabold text-sm">Informasi Kunjungan</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tanggal Pemeriksaan</label>
                            <input type="date" value="{{ date('Y-m-d') }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Usia Bayi (Bulan)</label>
                            <input type="number" placeholder="Contoh: 24" value="28" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                    </div>
                </div>

                <!-- 2. TANDA VITAL & ANTROPOMETRI -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center space-x-2 text-teal-800 border-b border-slate-100 pb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        <h3 class="font-extrabold text-sm">Tanda Vital & Antropometri</h3>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-xs">
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Berat Badan (kg)</label>
                            <input type="number" step="0.1" placeholder="0.0" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Tinggi Badan (cm)</label>
                            <input type="number" step="0.1" placeholder="0.0" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Lingkar Kepala (cm)</label>
                            <input type="number" step="0.1" placeholder="0.0" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Lingkar Lengan / LILA (cm)</label>
                            <input type="number" step="0.1" placeholder="0.0" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        </div>
                    </div>
                </div>

                <!-- 3. STATUS & IMUNISASI -->
                <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                    <div class="flex items-center space-x-2 text-teal-800 border-b border-slate-100 pb-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        <h3 class="font-extrabold text-sm">Status Pemberian Vitamin & Catatan</h3>
                    </div>

                    <div class="space-y-3 text-xs">
                        <div class="flex items-center space-x-3 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            <input type="checkbox" id="vitA" class="w-4 h-4 rounded text-teal-700 focus:ring-teal-500 border-slate-300">
                            <label for="vitA" class="font-bold text-slate-700 cursor-pointer">Pemberian Vitamin A Bulan Ini</label>
                        </div>

                        <div class="flex items-center space-x-3 bg-slate-50 p-3 rounded-2xl border border-slate-100">
                            <input type="checkbox" id="obatCacing" class="w-4 h-4 rounded text-teal-700 focus:ring-teal-500 border-slate-300">
                            <label for="obatCacing" class="font-bold text-slate-700 cursor-pointer">Pemberian Obat Cacing</label>
                        </div>

                        <div>
                            <label class="block font-bold text-slate-700 mb-1">Catatan / Rekomendasi Kader</label>
                            <textarea rows="3" placeholder="Contoh: Pertumbuhan baik, berat badan sesuai dengan grafik WHO..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none"></textarea>
                        </div>
                    </div>
                </div>

                <!-- SUBMIT BUTTON -->
                <button type="submit" class="w-full py-3.5 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs rounded-2xl shadow-md transition-all text-center block">
                    Simpan Hasil Pemeriksaan
                </button>

            </form>

        </div>
    </div>
</x-app-layout>