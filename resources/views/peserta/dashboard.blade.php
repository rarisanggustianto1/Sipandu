<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-teal-800 leading-tight">
                    {{ __('Beranda Keluarga') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Selamat datang di SiPANDU! Pantau jadwal posyandu, tumbuh kembang, dan status rujukan kesehatan keluarga Anda.
                </p>
            </div>
            <div class="inline-flex items-center gap-2 self-start sm:self-auto bg-teal-50 text-teal-800 border border-teal-200/80 px-3.5 py-1.5 rounded-full text-xs font-semibold">
                <span class="w-2 h-2 rounded-full bg-teal-500 animate-pulse"></span>
                <span>Posyandu Mawar 01 • Wilayah Kerja Puskesmas</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- ── 1. Banner Sambutan & Pengingat Jadwal Posyandu ────────── -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <!-- Welcome Card -->
            <div class="lg:col-span-2 relative overflow-hidden rounded-2xl bg-gradient-to-r from-teal-800 to-teal-600 text-white p-6 sm:p-7 shadow-sm flex flex-col justify-between">
                <div class="relative z-10 space-y-2">
                    <span class="inline-block px-3 py-1 bg-teal-900/60 text-teal-200 text-xs font-semibold rounded-full border border-teal-700/50">
                        SiPANDU • Modul Keluarga
                    </span>
                    <h1 class="text-2xl font-bold tracking-tight">Halo, Keluarga {{ Auth::user()->name ?? 'Peserta' }}! 👋</h1>
                    <p class="text-teal-100 text-xs sm:text-sm max-w-xl leading-relaxed">
                        Pastikan anak, ibu hamil, dan lansia mendapatkan pemantauan antropometri, vitamin A, serta imunisasi berkala tepat waktu di posyandu binaan.
                    </p>
                </div>

                <div class="relative z-10 pt-5 mt-4 border-t border-teal-700/60 flex flex-wrap items-center gap-3">
                    <a href="{{ route('peserta.data.index') }}" 
                       class="px-4 py-2 bg-white text-teal-800 hover:bg-teal-50 rounded-lg text-xs font-bold transition shadow-sm inline-flex items-center gap-1.5">
                        <svg class="w-4 h-4 text-teal-600" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z" />
                        </svg>
                        <span>Lihat Rekam Medis</span>
                    </a>
                    <a href="{{ route('peserta.keluarga.index') }}" 
                       class="px-4 py-2 bg-teal-900/60 hover:bg-teal-900/80 text-white rounded-lg text-xs font-semibold transition border border-teal-600/70">
                        Profil Anggota Keluarga
                    </a>
                </div>

                <div class="absolute -right-8 -bottom-8 w-48 h-48 rounded-full bg-white/10 blur-2xl pointer-events-none"></div>
            </div>

            <!-- Banner Pengingat Jadwal Posyandu Berikutnya -->
            <div class="bg-white rounded-2xl border border-teal-100 p-6 shadow-sm flex flex-col justify-between relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-teal-50 rounded-bl-full pointer-events-none"></div>
                
                <div>
                    <div class="flex items-center gap-2 text-teal-700 mb-3">
                        <span class="p-2 rounded-xl bg-teal-50 border border-teal-100">
                            <!-- Calendar Icon -->
                            <svg class="w-5 h-5 text-teal-700" fill="none" viewBox="0 0 24 24" stroke-width="1.75" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.253M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </span>
                        <div>
                            <span class="text-[11px] font-bold uppercase tracking-wider text-teal-800/80 block">Pengingat Jadwal</span>
                            <span class="text-xs font-semibold text-gray-700">Posyandu Berikutnya</span>
                        </div>
                    </div>

                    <div class="mt-4 p-4 rounded-xl bg-teal-50/70 border border-teal-100/80 space-y-1.5">
                        <p class="text-xs text-gray-500 font-medium">Tanggal Pelaksanaan:</p>
                        <h3 class="text-xl font-extrabold text-teal-800">Kamis, 15 Okt 2026</h3>
                        <div class="flex items-center gap-1.5 text-xs text-gray-600 pt-1">
                            <svg class="w-4 h-4 text-teal-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>Pukul 08:30 - 11:30 WIB</span>
                        </div>
                    </div>

                    <div class="mt-3 flex items-start gap-2 text-xs text-gray-600">
                        <svg class="w-4 h-4 text-teal-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        <span>Balai Dusun Mawar RT 02 / RW 01 (Posyandu Mawar 01)</span>
                    </div>
                </div>

                <div class="mt-4 pt-3 border-t border-gray-100 flex items-center justify-between text-[11px] text-teal-700 font-semibold">
                    <span>Jangan lupa bawa buku KIA!</span>
                    <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
                </div>
            </div>
        </div>

        <!-- ── 2. Ringkasan Kartu Statistik Cepat ─────────────────────── -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Anggota Keluarga</p>
                    <h3 class="text-2xl font-extrabold text-gray-800 mt-1">4 Jiwa</h3>
                    <p class="text-xs text-teal-600 font-medium mt-1">1 Balita • 1 Bumil • 1 Lansia</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-lg">
                    👨‍👩‍👦
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status Gizi Balita</p>
                    <h3 class="text-2xl font-extrabold text-emerald-600 mt-1">Gizi Baik</h3>
                    <p class="text-xs text-gray-500 font-medium mt-1">Sesuai Kurva Pertumbuhan</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center font-bold text-lg">
                    📈
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Imunisasi Lengkap</p>
                    <h3 class="text-2xl font-extrabold text-blue-600 mt-1">92%</h3>
                    <p class="text-xs text-blue-600 font-medium mt-1">Tinggal Campak-Rubella</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center font-bold text-lg">
                    💉
                </div>
            </div>

            <div class="bg-white p-5 rounded-xl border border-gray-100 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-[11px] font-bold text-gray-400 uppercase tracking-wider">Status Rujukan</p>
                    <h3 class="text-2xl font-extrabold text-teal-700 mt-1">Aman</h3>
                    <p class="text-xs text-teal-600 font-medium mt-1">Tidak Ada Rujukan Darurat</p>
                </div>
                <div class="w-11 h-11 rounded-xl bg-teal-50 text-teal-700 flex items-center justify-center font-bold text-lg">
                    🩺
                </div>
            </div>
        </div>

        <!-- ── 3. Status Rujukan & Tindak Lanjut dari Kader/Puskesmas ─── -->
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="p-5 border-b border-gray-100 flex items-center justify-between">
                <div class="flex items-center gap-2.5">
                    <span class="w-2.5 h-2.5 rounded-full bg-teal-500"></span>
                    <h3 class="font-bold text-base text-gray-800">Status Rujukan & Tindak Lanjut Kesehatan</h3>
                </div>
                <span class="px-2.5 py-1 bg-teal-50 text-teal-700 text-xs font-semibold rounded-lg border border-teal-200/60">
                    Terverifikasi Petugas Nakes
                </span>
            </div>

            <div class="p-5 space-y-3">
                <!-- Rujukan Item 1 (Konsultasi Gizi) -->
                <div class="p-4 rounded-xl border border-teal-100 bg-teal-50/40 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center font-bold text-sm shrink-0">
                            👶
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-sm text-gray-800">Pemantauan Tambahan MPASI (Anak Pertama)</h4>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-800 text-[10px] font-bold">Sedang Berjalan</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Anjuran dari Kader Posyandu Mawar 01: Berikan variasi protein hewani (telur, hati ayam, ikan kembung) 2x sehari untuk optimalisasi berat badan.
                            </p>
                            <span class="text-[11px] text-teal-700 font-medium mt-1.5 inline-block">Instruksi: Bidan Pembina Wilayah Puskesmas</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-end md:self-auto shrink-0">
                        <a href="{{ route('peserta.data.index') }}" 
                           class="px-3.5 py-1.5 bg-white border border-teal-200 text-teal-700 hover:bg-teal-50 rounded-lg text-xs font-semibold transition">
                            Cek KMS
                        </a>
                    </div>
                </div>

                <!-- Rujukan Item 2 (Pemeriksaan Ibu Hamil) -->
                <div class="p-4 rounded-xl border border-rose-100 bg-rose-50/30 flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex items-start gap-3.5">
                        <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center font-bold text-sm shrink-0">
                            🤰
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h4 class="font-bold text-sm text-gray-800">Konsultasi Tablet Tambah Darah (Ibu Hamil)</h4>
                                <span class="px-2 py-0.5 rounded-full bg-blue-100 text-blue-800 text-[10px] font-bold">Rekomendasi</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">
                                Konsumsi rutin Tablet Tambah Darah (TTD) 1 tablet per hari di malam hari dengan air putih atau jus jeruk untuk menghindari mual.
                            </p>
                            <span class="text-[11px] text-rose-700 font-medium mt-1.5 inline-block">Kader Pendamping: Ibu Sri Wahyuni (Posyandu)</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 self-end md:self-auto shrink-0">
                        <a href="{{ route('peserta.edukasi.index', ['kategori' => 'ibu_hamil']) }}" 
                           class="px-3.5 py-1.5 bg-white border border-rose-200 text-rose-700 hover:bg-rose-50 rounded-lg text-xs font-semibold transition">
                            Materi Bumil
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>