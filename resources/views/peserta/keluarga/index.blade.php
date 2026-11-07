<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-teal-800 leading-tight">
                    {{ __('Anggota Keluarga') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Kartu kesehatan digital dan profil anggota keluarga terdaftar pada Posyandu.
                </p>
            </div>
            <a href="{{ route('peserta.keluarga.edit', 1) }}" 
               class="inline-flex items-center gap-1.5 self-start sm:self-auto px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                </svg>
                <span>Edit Profil KK</span>
            </a>
        </div>
    </x-slot>

    @php
        $activeTab = request('tab', 'semua');
    @endphp

    <div class="space-y-6">

        <!-- ── 1. Kartu Kesehatan Digital (Digital Health Family Card) ── -->
        <div class="relative overflow-hidden rounded-2xl bg-gradient-to-br from-teal-800 via-teal-700 to-teal-900 text-white p-6 sm:p-8 shadow-md">
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div class="space-y-3">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('images/sipandu-logo.png') }}" alt="Logo" class="h-10 w-auto bg-white/10 p-1 rounded-lg backdrop-blur-sm">
                        <div>
                            <span class="text-xs uppercase tracking-widest text-teal-200 font-bold block">Kartu Kesehatan Digital Posyandu</span>
                            <span class="text-xs text-teal-100">SiPANDU • Terintegrasi Puskesmas</span>
                        </div>
                    </div>

                    <div class="pt-2">
                        <p class="text-xs text-teal-200 font-medium">Nomor Kartu Keluarga (KK):</p>
                        <h2 class="text-xl sm:text-2xl font-mono font-bold tracking-wider">1871 0000 0000 0001</h2>
                    </div>

                    <div class="grid grid-cols-2 sm:grid-cols-3 gap-4 pt-1 text-xs">
                        <div>
                            <span class="text-teal-300 block">Kepala Keluarga</span>
                            <span class="font-bold text-white text-sm">{{ Auth::user()->name ?? 'Bapak Kepala Keluarga' }}</span>
                        </div>
                        <div>
                            <span class="text-teal-300 block">Posyandu Binaan</span>
                            <span class="font-bold text-white text-sm">Posyandu Mawar 01</span>
                        </div>
                        <div>
                            <span class="text-teal-300 block">Alamat Domisili</span>
                            <span class="font-bold text-white text-sm">Bandar Lampung</span>
                        </div>
                    </div>
                </div>

                <!-- QR Code & Status Digital Card -->
                <div class="self-start md:self-center bg-white/10 backdrop-blur-md border border-white/20 p-4 rounded-xl text-center shrink-0">
                    <div class="w-20 h-20 bg-white rounded-lg p-1.5 mx-auto flex items-center justify-center shadow-inner">
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=SIPANDU-KK-1871000000000001" alt="QR" class="w-full h-full object-contain">
                    </div>
                    <span class="text-[10px] uppercase font-bold text-teal-200 tracking-wider block mt-2">Kartu Aktif</span>
                </div>
            </div>

            <!-- Background Aesthetic Circle -->
            <div class="absolute -right-12 -top-12 w-64 h-64 rounded-full bg-teal-500/20 blur-3xl pointer-events-none"></div>
            <div class="absolute -left-12 -bottom-12 w-64 h-64 rounded-full bg-teal-400/20 blur-3xl pointer-events-none"></div>
        </div>

        <!-- ── 2. Switch Profil Kategori (Tabs Filter) ──────────────── -->
        <div class="bg-white p-3 rounded-xl border border-gray-200/80 shadow-sm flex flex-wrap items-center justify-between gap-3">
            <div class="flex items-center gap-1.5 overflow-x-auto py-1 max-w-full">
                <!-- Semua -->
                <a href="{{ route('peserta.keluarga.index', ['tab' => 'semua']) }}"
                   class="px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ $activeTab === 'semua' ? 'bg-teal-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    Semua Anggota
                </a>

                <!-- Anak / Balita -->
                <a href="{{ route('peserta.keluarga.index', ['tab' => 'balita']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ $activeTab === 'balita' ? 'bg-teal-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <span>👶</span>
                    <span>Anak / Balita</span>
                </a>

                <!-- Ibu Hamil (Bumil) -->
                <a href="{{ route('peserta.keluarga.index', ['tab' => 'bumil']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ $activeTab === 'bumil' ? 'bg-teal-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <span>🤰</span>
                    <span>Ibu Hamil (Bumil)</span>
                </a>

                <!-- Lansia -->
                <a href="{{ route('peserta.keluarga.index', ['tab' => 'lansia']) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-xs sm:text-sm font-semibold transition-all whitespace-nowrap {{ $activeTab === 'lansia' ? 'bg-teal-700 text-white shadow-sm' : 'text-gray-600 hover:bg-gray-100 hover:text-gray-900' }}">
                    <span>🧓</span>
                    <span>Lansia</span>
                </a>
            </div>

            <span class="text-xs text-gray-500 font-medium px-2">
                Pilih kategori untuk melihat catatan kesehatan spesifik
            </span>
        </div>

        <!-- ── 3. Grid Kartu Anggota Keluarga ───────────────────────── -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
            
            <!-- Profil 1: Balita -->
            @if ($activeTab === 'semua' || $activeTab === 'balita')
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-teal-100 text-teal-800 flex items-center justify-center text-xl shrink-0">
                                    👶
                                </div>
                                <div>
                                    <span class="px-2 py-0.5 rounded-full bg-teal-50 text-teal-700 text-[10px] font-bold border border-teal-200/60">
                                        Anak / Balita
                                    </span>
                                    <h3 class="font-bold text-base text-gray-800 mt-1">Anak Balita Pertama</h3>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 text-xs space-y-1.5 text-gray-600 border-t border-gray-100">
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">NIK Balita:</span>
                                <span class="font-semibold text-gray-800 font-mono">1871020000000002</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Usia:</span>
                                <span class="font-semibold text-gray-800">24 Bulan (2 Tahun)</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Jenis Kelamin:</span>
                                <span class="font-semibold text-gray-800">Laki-laki</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Status Gizi:</span>
                                <span class="font-semibold text-emerald-600">Baik / Sesuai Kurva</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[11px] text-teal-600 font-medium">Buku KIA Digital Aktif</span>
                        <a href="{{ route('peserta.data.show', 1) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-teal-50 text-teal-700 hover:bg-teal-100 rounded-lg text-xs font-semibold transition">
                            <span>Rekam Medis</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Profil 2: Ibu Hamil (Bumil) -->
            @if ($activeTab === 'semua' || $activeTab === 'bumil')
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-800 flex items-center justify-center text-xl shrink-0">
                                    🤰
                                </div>
                                <div>
                                    <span class="px-2 py-0.5 rounded-full bg-rose-50 text-rose-700 text-[10px] font-bold border border-rose-200/60">
                                        Ibu Hamil (Bumil)
                                    </span>
                                    <h3 class="font-bold text-base text-gray-800 mt-1">Ibu Rumah Tangga</h3>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 text-xs space-y-1.5 text-gray-600 border-t border-gray-100">
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Usia Kehamilan:</span>
                                <span class="font-semibold text-gray-800">28 Minggu (Trimester 3)</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Taksiran Persalinan:</span>
                                <span class="font-semibold text-gray-800">12 Desember 2026</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Pemeriksaan ANC:</span>
                                <span class="font-semibold text-teal-700">Sudah 4x (Lengkap)</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Hb Terakhir:</span>
                                <span class="font-semibold text-emerald-600">12.2 g/dL (Normal)</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[11px] text-rose-600 font-medium">Buku KIA Bumil Aktif</span>
                        <a href="{{ route('peserta.edukasi.index', ['kategori' => 'ibu_hamil']) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-rose-50 text-rose-700 hover:bg-rose-100 rounded-lg text-xs font-semibold transition">
                            <span>Panduan Nutrisi</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

            <!-- Profil 3: Lansia -->
            @if ($activeTab === 'semua' || $activeTab === 'lansia')
                <div class="bg-white rounded-2xl border border-gray-200/80 p-5 shadow-sm hover:shadow-md transition flex flex-col justify-between">
                    <div class="space-y-3">
                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div class="w-12 h-12 rounded-xl bg-blue-100 text-blue-800 flex items-center justify-center text-xl shrink-0">
                                    🧓
                                </div>
                                <div>
                                    <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700 text-[10px] font-bold border border-blue-200/60">
                                        Lansia (Posyandu Lansia)
                                    </span>
                                    <h3 class="font-bold text-base text-gray-800 mt-1">Kakek / Nenek Keluarga</h3>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 text-xs space-y-1.5 text-gray-600 border-t border-gray-100">
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Usia:</span>
                                <span class="font-semibold text-gray-800">67 Tahun</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Tekanan Darah:</span>
                                <span class="font-semibold text-emerald-600">125/80 mmHg (Normal)</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Gula Darah Sewaktu:</span>
                                <span class="font-semibold text-gray-800">110 mg/dL</span>
                            </div>
                            <div class="flex justify-between py-0.5">
                                <span class="text-gray-400">Kebugaran Lansia:</span>
                                <span class="font-semibold text-blue-700">Aktif Senam Rutin</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 mt-3 border-t border-gray-100 flex items-center justify-between">
                        <span class="text-[11px] text-blue-600 font-medium">KMS Lansia Terintegrasi</span>
                        <a href="{{ route('peserta.edukasi.index', ['kategori' => 'lansia']) }}" 
                           class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-50 text-blue-700 hover:bg-blue-100 rounded-lg text-xs font-semibold transition">
                            <span>Tips Lansia</span>
                            <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </a>
                    </div>
                </div>
            @endif

        </div>

    </div>
</x-app-layout>