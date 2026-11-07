<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center gap-4">
            <a href="{{ route('peserta.keluarga.index') }}" 
               class="inline-flex items-center gap-2 text-sm font-medium text-gray-600 hover:text-teal-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                <span>Kembali</span>
            </a>
            <div class="h-5 w-px bg-gray-200"></div>
            <h2 class="font-bold text-xl text-teal-800 leading-tight">
                {{ __('Edit Informasi Keluarga') }}
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <div class="bg-white p-6 sm:p-8 rounded-xl border border-gray-100 shadow-sm">
            <div class="mb-5 pb-4 border-b border-gray-100">
                <h3 class="font-bold text-lg text-gray-800">Form Pembaruan Data Keluarga</h3>
                <p class="text-xs text-gray-500 mt-0.5">Perbarui nomor kontak dan alamat domisili untuk keperluan data posyandu.</p>
            </div>
            
            <form action="#" method="POST" class="space-y-4 text-sm">
                @csrf
                @method('PUT')

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nomor Kartu Keluarga (KK)</label>
                    <input type="text" value="1871000000000001" class="w-full p-2.5 border rounded-lg bg-gray-50 text-gray-500 focus:outline-none" readonly>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Nama Kepala Keluarga</label>
                    <input type="text" value="Bapak Kepala Keluarga" class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">Alamat Domisili</label>
                    <textarea class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none" rows="3">Bandar Lampung</textarea>
                </div>

                <div>
                    <label class="block text-gray-700 font-medium mb-1">No. Kontak / WhatsApp</label>
                    <input type="text" value="085767188610" class="w-full p-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-teal-500 focus:outline-none">
                </div>

                <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                    <a href="{{ route('peserta.keluarga.index') }}" 
                       class="px-4 py-2 border border-gray-200 text-gray-600 rounded-lg hover:bg-gray-50 text-xs font-semibold transition">
                        Batal
                    </a>
                    <button type="button" 
                            class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white rounded-lg text-xs font-semibold shadow-sm transition">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>