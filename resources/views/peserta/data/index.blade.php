<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
            <div>
                <h2 class="font-bold text-2xl text-teal-800 leading-tight">
                    {{ __('Rekam Medis & Riwayat Tumbuh Kembang') }}
                </h2>
                <p class="text-xs text-gray-500 mt-1">
                    Grafik Kartu Menuju Sehat (KMS), catatan timbangan bulanan, dan status imunisasi balita.
                </p>
            </div>
            <div class="inline-flex items-center gap-2 self-start sm:self-auto bg-teal-50 border border-teal-200/80 px-3.5 py-1.5 rounded-full text-xs font-semibold text-teal-800">
                <span>Anak: <strong>Anak Balita Pertama</strong> (24 Bulan)</span>
            </div>
        </div>
    </x-slot>

    <div class="space-y-6">

        <!-- ── 1. Grafik Perkembangan (KMS) ─────────────────────────── -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-base text-gray-800">Grafik Kartu Menuju Sehat (KMS) Digital</h3>
                    <p class="text-xs text-gray-500">Kurva lintasan penimbangan berat badan (kg) terhadap usia balita (bulan).</p>
                </div>
                <div class="flex items-center gap-3 text-xs">
                    <span class="inline-flex items-center gap-1.5 text-gray-600 font-medium">
                        <span class="w-3 h-3 rounded bg-teal-600"></span> Berat Balita
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-600 font-medium">
                        <span class="w-3 h-3 rounded bg-emerald-300"></span> Garis Hijau (Normal)
                    </span>
                    <span class="inline-flex items-center gap-1.5 text-gray-600 font-medium">
                        <span class="w-3 h-3 rounded bg-amber-300"></span> Batas Waspada
                    </span>
                </div>
            </div>

            <!-- Area Visualisasi Grafik KMS (SVG Interaktif & Responsif) -->
            <div class="relative w-full h-64 bg-slate-50/70 rounded-xl border border-slate-200/70 p-4 flex flex-col justify-between">
                <!-- SVG Chart Curve -->
                <svg class="w-full h-full overflow-visible" viewBox="0 0 600 200" preserveAspectRatio="none">
                    <!-- Garis Batas Bawah / Warning (Kuning Lembut) -->
                    <path d="M 30 180 Q 200 150, 350 125 T 570 95" fill="none" stroke="#fcd34d" stroke-width="3" stroke-dasharray="4" />
                    <!-- Area Hijau Kurva Normal (Emerald Green) -->
                    <path d="M 30 160 Q 200 120, 350 90 T 570 50" fill="none" stroke="#6ee7b7" stroke-width="3" />
                    <!-- Garis Riwayat Pertumbuhan Balita (Teal Primary Bold) -->
                    <path d="M 30 170 L 120 145 L 210 125 L 300 108 L 390 92 L 480 80 L 570 70" fill="none" stroke="#0d9488" stroke-width="3.5" stroke-linecap="round" />
                    
                    <!-- Titik-titik Pengukuran (Data Points) -->
                    <circle cx="30" cy="170" r="5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                    <circle cx="120" cy="145" r="5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                    <circle cx="210" cy="125" r="5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                    <circle cx="300" cy="108" r="5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                    <circle cx="390" cy="92" r="5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                    <circle cx="480" cy="80" r="5" fill="#0d9488" stroke="#ffffff" stroke-width="2" />
                    <circle cx="570" cy="70" r="6" fill="#047857" stroke="#ffffff" stroke-width="2.5" class="animate-pulse" />
                </svg>

                <!-- Sumbu X: Usia Bulan -->
                <div class="flex justify-between text-[11px] font-mono text-gray-500 pt-2 border-t border-gray-200">
                    <span>0 Bln (3.2 kg)</span>
                    <span>4 Bln (6.4 kg)</span>
                    <span>8 Bln (8.1 kg)</span>
                    <span>12 Bln (9.4 kg)</span>
                    <span>16 Bln (10.2 kg)</span>
                    <span>20 Bln (10.9 kg)</span>
                    <span class="font-bold text-teal-800">24 Bln (11.5 kg) ★</span>
                </div>
            </div>

            <div class="p-3 bg-emerald-50 border border-emerald-200 rounded-xl flex items-center justify-between text-xs text-emerald-800">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-emerald-600"></span>
                    <span><strong>Interpretasi Pertumbuhan:</strong> Berat badan anak naik mengikuti pita hijau (N). Tumbuh kembang sangat ideal.</span>
                </div>
                <span class="font-bold">Status: Normal / Baik</span>
            </div>
        </div>

        <!-- ── 2. Status Imunisasi, Vaksin, dan Vitamin ──────────────── -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-base text-gray-800">Status Kelengkapan Imunisasi & Vitamin</h3>
                    <p class="text-xs text-gray-500">Pemberian vaksin dasar lengkap dan vitamin A sesuai usia anak.</p>
                </div>
                <span class="px-3 py-1 bg-teal-50 text-teal-700 text-xs font-bold rounded-full border border-teal-200/60">
                    6 dari 7 Vaksin Terpenuhi
                </span>
            </div>

            <div class="grid grid-cols-2 sm:grid-cols-4 lg:grid-cols-7 gap-3">
                <!-- Vaksin 1: Hepatitis B (0 Bln) -->
                <div class="p-3 rounded-xl border border-emerald-200 bg-emerald-50/50 text-center">
                    <span class="inline-block p-1 rounded-full bg-emerald-100 text-emerald-700 mb-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </span>
                    <h4 class="font-bold text-xs text-gray-800">Hep-B 0</h4>
                    <p class="text-[10px] text-gray-500">0 Bulan</p>
                    <span class="mt-1.5 inline-block text-[9px] font-bold text-emerald-700 bg-emerald-100/70 px-1.5 py-0.5 rounded">Sudah</span>
                </div>

                <!-- Vaksin 2: BCG & Polio 1 -->
                <div class="p-3 rounded-xl border border-emerald-200 bg-emerald-50/50 text-center">
                    <span class="inline-block p-1 rounded-full bg-emerald-100 text-emerald-700 mb-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </span>
                    <h4 class="font-bold text-xs text-gray-800">BCG & Polio 1</h4>
                    <p class="text-[10px] text-gray-500">1 Bulan</p>
                    <span class="mt-1.5 inline-block text-[9px] font-bold text-emerald-700 bg-emerald-100/70 px-1.5 py-0.5 rounded">Sudah</span>
                </div>

                <!-- Vaksin 3: DPT-HB-Hib 1 -->
                <div class="p-3 rounded-xl border border-emerald-200 bg-emerald-50/50 text-center">
                    <span class="inline-block p-1 rounded-full bg-emerald-100 text-emerald-700 mb-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </span>
                    <h4 class="font-bold text-xs text-gray-800">DPT-HB-Hib 1</h4>
                    <p class="text-[10px] text-gray-500">2 Bulan</p>
                    <span class="mt-1.5 inline-block text-[9px] font-bold text-emerald-700 bg-emerald-100/70 px-1.5 py-0.5 rounded">Sudah</span>
                </div>

                <!-- Vaksin 4: DPT-HB-Hib 2 -->
                <div class="p-3 rounded-xl border border-emerald-200 bg-emerald-50/50 text-center">
                    <span class="inline-block p-1 rounded-full bg-emerald-100 text-emerald-700 mb-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </span>
                    <h4 class="font-bold text-xs text-gray-800">DPT-HB-Hib 2</h4>
                    <p class="text-[10px] text-gray-500">3 Bulan</p>
                    <span class="mt-1.5 inline-block text-[9px] font-bold text-emerald-700 bg-emerald-100/70 px-1.5 py-0.5 rounded">Sudah</span>
                </div>

                <!-- Vaksin 5: DPT-HB-Hib 3 -->
                <div class="p-3 rounded-xl border border-emerald-200 bg-emerald-50/50 text-center">
                    <span class="inline-block p-1 rounded-full bg-emerald-100 text-emerald-700 mb-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </span>
                    <h4 class="font-bold text-xs text-gray-800">DPT-HB-Hib 3</h4>
                    <p class="text-[10px] text-gray-500">4 Bulan</p>
                    <span class="mt-1.5 inline-block text-[9px] font-bold text-emerald-700 bg-emerald-100/70 px-1.5 py-0.5 rounded">Sudah</span>
                </div>

                <!-- Vaksin 6: Campak-Rubella (MR) -->
                <div class="p-3 rounded-xl border border-emerald-200 bg-emerald-50/50 text-center">
                    <span class="inline-block p-1 rounded-full bg-emerald-100 text-emerald-700 mb-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                    </span>
                    <h4 class="font-bold text-xs text-gray-800">Campak (MR)</h4>
                    <p class="text-[10px] text-gray-500">9 Bulan</p>
                    <span class="mt-1.5 inline-block text-[9px] font-bold text-emerald-700 bg-emerald-100/70 px-1.5 py-0.5 rounded">Sudah</span>
                </div>

                <!-- Vaksin 7: Booster Lanjutan (18-24 Bln) -->
                <div class="p-3 rounded-xl border border-amber-200 bg-amber-50/60 text-center">
                    <span class="inline-block p-1 rounded-full bg-amber-100 text-amber-700 mb-1">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                    </span>
                    <h4 class="font-bold text-xs text-gray-800">Booster MR</h4>
                    <p class="text-[10px] text-gray-500">24 Bulan</p>
                    <span class="mt-1.5 inline-block text-[9px] font-bold text-amber-800 bg-amber-100 px-1.5 py-0.5 rounded">Jadwal Ini</span>
                </div>
            </div>
        </div>

        <!-- ── 3. Riwayat Timbang Bulanan (Tabel Antropometri) ───────── -->
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm space-y-4">
            <div class="flex items-center justify-between pb-3 border-b border-gray-100">
                <div>
                    <h3 class="font-bold text-base text-gray-800">Riwayat Penimbangan & Pengukuran Bulanan</h3>
                    <p class="text-xs text-gray-500">Rekapitulasi pengukuran antropometri berat badan, panjang badan, dan lingkar kepala.</p>
                </div>
            </div>

            <div class="overflow-x-auto border border-gray-100 rounded-xl">
                <table class="w-full text-left text-sm text-gray-600">
                    <thead class="bg-teal-50 text-teal-800 font-semibold text-xs uppercase tracking-wider">
                        <tr>
                            <th class="p-3.5">Tanggal Periksa</th>
                            <th class="p-3.5">Usia</th>
                            <th class="p-3.5">Berat Badan (BB)</th>
                            <th class="p-3.5">Tinggi Badan (TB)</th>
                            <th class="p-3.5">Lingkar Kepala</th>
                            <th class="p-3.5">Status Gizi</th>
                            <th class="p-3.5 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-xs">
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3.5 font-bold text-gray-800">10 Oktober 2026</td>
                            <td class="p-3.5">24 Bulan</td>
                            <td class="p-3.5 font-semibold text-teal-800">11.5 kg</td>
                            <td class="p-3.5">85 cm</td>
                            <td class="p-3.5">47 cm</td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-[11px] rounded-full font-bold">
                                    Normal / Baik
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <a href="{{ route('peserta.data.show', 1) }}" class="text-teal-600 hover:text-teal-800 font-bold hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3.5 font-bold text-gray-800">12 September 2026</td>
                            <td class="p-3.5">23 Bulan</td>
                            <td class="p-3.5 font-semibold text-teal-800">11.2 kg</td>
                            <td class="p-3.5">84 cm</td>
                            <td class="p-3.5">46.8 cm</td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-[11px] rounded-full font-bold">
                                    Normal / Baik
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <a href="{{ route('peserta.data.show', 1) }}" class="text-teal-600 hover:text-teal-800 font-bold hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        <tr class="hover:bg-slate-50 transition">
                            <td class="p-3.5 font-bold text-gray-800">15 Agustus 2026</td>
                            <td class="p-3.5">22 Bulan</td>
                            <td class="p-3.5 font-semibold text-teal-800">10.9 kg</td>
                            <td class="p-3.5">83.2 cm</td>
                            <td class="p-3.5">46.5 cm</td>
                            <td class="p-3.5">
                                <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-[11px] rounded-full font-bold">
                                    Normal / Baik
                                </span>
                            </td>
                            <td class="p-3.5 text-center">
                                <a href="{{ route('peserta.data.show', 1) }}" class="text-teal-600 hover:text-teal-800 font-bold hover:underline">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</x-app-layout>