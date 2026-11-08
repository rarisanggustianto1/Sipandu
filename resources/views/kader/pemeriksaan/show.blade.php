<x-app-layout>
    <div class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center space-x-3">
                <a href="{{ route('kader.pemeriksaan.index') }}" class="p-2.5 bg-white rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Detail Hasil Pemeriksaan</h1>
            </div>

            <!-- CARD DETAIL -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-200/80 shadow-xs space-y-6">
                <!-- Info Header Peserta -->
                <div class="p-5 bg-teal-50 rounded-2xl border border-teal-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                    <div>
                        <span class="text-[10px] font-bold uppercase tracking-wider text-teal-800 bg-teal-100/70 px-2.5 py-0.5 rounded-full">
                            {{ ucfirst($pemeriksaan->peserta->kategori ?? 'Peserta') }}
                        </span>
                        <h2 class="text-xl font-extrabold text-slate-800 mt-1">{{ $pemeriksaan->peserta->nama ?? '-' }}</h2>
                        <p class="text-xs text-slate-500 mt-0.5">NIK: {{ $pemeriksaan->peserta->nik ?? '-' }} • Keluarga: {{ $pemeriksaan->peserta->keluarga->nama_kepala_keluarga ?? '-' }}</p>
                    </div>
                    <div class="text-right sm:self-center">
                        <span class="text-xs text-slate-500 block">Tanggal Periksa:</span>
                        <span class="text-sm font-bold text-slate-800">{{ $pemeriksaan->tanggal_pemeriksaan?->format('d F Y') ?? '-' }}</span>
                    </div>
                </div>

                <!-- Hasil Pengukuran -->
                @if ($pemeriksaan->balita)
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Antropometri Balita</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Berat Badan</span>
                                <span class="text-base font-bold text-teal-800 mt-1 block">{{ $pemeriksaan->balita->berat_badan ?? '-' }} kg</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Tinggi Badan</span>
                                <span class="text-base font-bold text-slate-800 mt-1 block">{{ $pemeriksaan->balita->tinggi_badan ?? '-' }} cm</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Lingkar Kepala</span>
                                <span class="text-base font-bold text-slate-800 mt-1 block">{{ $pemeriksaan->balita->lingkar_kepala ?? '-' }} cm</span>
                            </div>
                            <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100">
                                <span class="text-emerald-700 block font-medium">Status Gizi</span>
                                <span class="text-base font-bold text-emerald-800 mt-1 block">{{ $pemeriksaan->balita->catatan_gizi ?? 'Normal' }}</span>
                            </div>
                        </div>
                    </div>
                @elseif ($pemeriksaan->bumil)
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Pemeriksaan Ibu Hamil</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Usia Kehamilan</span>
                                <span class="text-base font-bold text-teal-800 mt-1 block">{{ $pemeriksaan->bumil->usia_kehamilan ?? '-' }} Minggu</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Tekanan Darah</span>
                                <span class="text-base font-bold text-slate-800 mt-1 block">{{ $pemeriksaan->bumil->tekanan_darah ?? '-' }}</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Tinggi Fundus</span>
                                <span class="text-base font-bold text-slate-800 mt-1 block">{{ $pemeriksaan->bumil->tinggi_fundus ?? '-' }} cm</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Denyut Jantung Janin</span>
                                <span class="text-base font-bold text-slate-800 mt-1 block">{{ $pemeriksaan->bumil->denyut_jantung_janin ?? '-' }} bpm</span>
                            </div>
                        </div>
                    </div>
                @elseif ($pemeriksaan->lansia)
                    <div>
                        <h3 class="text-sm font-bold text-slate-800 mb-3 border-b border-slate-100 pb-2">Pemeriksaan Kesehatan Lansia</h3>
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center text-xs">
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Tekanan Darah</span>
                                <span class="text-base font-bold text-teal-800 mt-1 block">{{ $pemeriksaan->lansia->tekanan_darah ?? '-' }}</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Gula Darah</span>
                                <span class="text-base font-bold text-slate-800 mt-1 block">{{ $pemeriksaan->lansia->gula_darah ?? '-' }} mg/dL</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Kolesterol</span>
                                <span class="text-base font-bold text-slate-800 mt-1 block">{{ $pemeriksaan->lansia->kolesterol ?? '-' }} mg/dL</span>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl border border-slate-100">
                                <span class="text-slate-400 block font-medium">Asam Urat</span>
                                <span class="text-base font-bold text-slate-800 mt-1 block">{{ $pemeriksaan->lansia->asam_urat ?? '-' }} mg/dL</span>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Catatan & Keluhan -->
                <div class="space-y-3 text-xs">
                    <div>
                        <span class="font-bold text-slate-700 block">Keluhan Peserta:</span>
                        <p class="text-slate-600 bg-slate-50 p-3 rounded-xl mt-1 border border-slate-100">{{ $pemeriksaan->keluhan ?: 'Tidak ada keluhan yang dilaporkan.' }}</p>
                    </div>
                    <div>
                        <span class="font-bold text-slate-700 block">Catatan & Anjuran Kader:</span>
                        <p class="text-slate-600 bg-slate-50 p-3 rounded-xl mt-1 border border-slate-100">{{ $pemeriksaan->catatan ?: 'Pertumbuhan dan kesehatan terpantau baik sesuai standar posyandu.' }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>

