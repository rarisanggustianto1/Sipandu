<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('peserta.data.index') }}" 
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-teal-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
            <div class="h-5 w-px bg-gray-200"></div>
            <h2 class="font-bold text-xl text-teal-800 leading-tight">
                {{ __('Detail Rekam Medis Balita') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        
        <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-100 shadow-sm">
            <div class="mb-5 pb-4 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-800">Rincian Rekam Medis & Imunisasi</h3>
                <p class="text-xs text-gray-500 mt-0.5">Catatan pemeriksaan berkala balita dari posyandu terdaftar.</p>
            </div>

            <div class="space-y-5 text-sm">
                <!-- Banner Balita -->
                <div class="p-4 bg-teal-50 rounded-xl text-teal-900 border border-teal-100 flex items-center justify-between">
                    <div>
                        <p class="font-bold text-base">Anak Balita Pertama</p>
                        <p class="text-xs text-teal-700 mt-0.5">Usia: 24 Bulan | Jenis Kelamin: Laki-laki</p>
                    </div>
                    <span class="px-2.5 py-1 bg-emerald-100 text-emerald-800 text-xs rounded-full font-semibold">
                        Gizi Baik
                    </span>
                </div>

                <!-- Antropometri Terakhir -->
                <div class="border-t border-gray-100 pt-4">
                    <h4 class="font-semibold text-gray-800 mb-3">Hasil Pemeriksaan Terakhir (10 Oktober 2026)</h4>
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 text-center">
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="text-xs text-gray-400 block font-medium">Berat Badan</span>
                            <span class="text-base font-bold text-gray-800 mt-1 block">11.5 kg</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="text-xs text-gray-400 block font-medium">Tinggi Badan</span>
                            <span class="text-base font-bold text-gray-800 mt-1 block">85 cm</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="text-xs text-gray-400 block font-medium">Lingkar Kepala</span>
                            <span class="text-base font-bold text-gray-800 mt-1 block">47 cm</span>
                        </div>
                        <div class="bg-gray-50 p-3 rounded-lg border border-gray-100">
                            <span class="text-xs text-gray-400 block font-medium">Status Gizi</span>
                            <span class="text-base font-bold text-teal-700 mt-1 block">Baik / Normal</span>
                        </div>
                    </div>
                </div>

                <!-- Catatan Kader -->
                <div class="border-t border-gray-100 pt-4">
                    <h4 class="font-semibold text-gray-800 mb-2">Catatan Kader Posyandu</h4>
                    <div class="p-4 bg-gray-50/70 border border-gray-100 rounded-xl text-gray-600 text-xs sm:text-sm italic leading-relaxed">
                        "Pertumbuhan anak sangat baik dan sesuai kurva KMS. Pertahankan pola makan gizi seimbang dan lanjutkan imunisasi berikutnya."
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>