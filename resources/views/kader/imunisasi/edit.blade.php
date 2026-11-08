<x-app-layout>
    <div class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center space-x-3">
                <a href="{{ route('kader.imunisasi.index') }}" class="p-2.5 bg-white rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Edit Data Imunisasi</h1>
            </div>

            <form action="{{ route('kader.imunisasi.update', $imunisasi->id) }}" method="POST" class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5 text-xs">
                @csrf
                @method('PUT')

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Peserta *</label>
                    <select name="peserta_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach ($peserta as $p)
                            <option value="{{ $p->id }}" @selected($imunisasi->peserta_id == $p->id)>{{ $p->nama }} ({{ ucfirst($p->kategori) }})</option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jenis Vaksin / Vitamin *</label>
                        <input type="text" name="jenis_imunisasi" value="{{ old('jenis_imunisasi', $imunisasi->jenis_imunisasi) }}" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal Pemberian</label>
                        <input type="date" name="tanggal_pemberian" value="{{ old('tanggal_pemberian', $imunisasi->tanggal_pemberian?->format('Y-m-d')) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="selesai" @selected($imunisasi->status === 'selesai')>Selesai Diberikan</option>
                        <option value="terjadwal" @selected($imunisasi->status === 'terjadwal')>Terjadwal</option>
                        <option value="terlewat" @selected($imunisasi->status === 'terlewat')>Terlewat</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan</label>
                    <textarea name="catatan" rows="3" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">{{ old('catatan', $imunisasi->catatan) }}</textarea>
                </div>

                <button type="submit" class="w-full py-3.5 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs rounded-2xl shadow-md transition-all text-center">
                    Perbarui Riwayat Imunisasi
                </button>
            </form>

        </div>
    </div>
</x-app-layout>

