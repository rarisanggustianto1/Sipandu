<x-app-layout>
    <div class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="flex items-center space-x-3">
                <a href="{{ route('kader.imunisasi.index') }}" class="p-2.5 bg-white rounded-2xl border border-slate-200 text-slate-600 hover:bg-slate-50 transition-all shadow-xs">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                </a>
                <h1 class="text-xl font-black text-slate-800 tracking-tight">Catat Imunisasi & Vitamin</h1>
            </div>

            <form action="{{ route('kader.imunisasi.store') }}" method="POST" class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-5 text-xs">
                @csrf

                @if ($errors->any())
                    <div class="p-3 bg-rose-50 border border-rose-200 text-rose-700 rounded-xl">
                        Periksa kembali isian formulir Anda.
                    </div>
                @endif

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Pilih Peserta *</label>
                    <select name="peserta_id" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">-- Pilih Peserta --</option>
                        @foreach ($peserta as $p)
                            <option value="{{ $p->id }}">{{ $p->nama }} ({{ ucfirst($p->kategori) }} - NIK: {{ $p->nik }})</option>
                        @endforeach
                    </select>
                    @error('peserta_id') <span class="text-rose-600">{{ $message }}</span> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Jenis Vaksin / Vitamin *</label>
                        <select name="jenis_imunisasi" required class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                            <option value="Hepatitis B-0">Hepatitis B-0</option>
                            <option value="BCG & Polio 1">BCG & Polio 1</option>
                            <option value="DPT-HB-Hib 1 & Polio 2">DPT-HB-Hib 1 & Polio 2</option>
                            <option value="DPT-HB-Hib 2 & Polio 3">DPT-HB-Hib 2 & Polio 3</option>
                            <option value="DPT-HB-Hib 3 & Polio 4">DPT-HB-Hib 3 & Polio 4</option>
                            <option value="IPV (Inactivated Polio Vaccine)">IPV (Inactivated Polio)</option>
                            <option value="Campak-Rubella (MR)">Campak-Rubella (MR)</option>
                            <option value="Vitamin A Biru (6-11 Bln)">Vitamin A Biru (100.000 IU)</option>
                            <option value="Vitamin A Merah (12-59 Bln)">Vitamin A Merah (200.000 IU)</option>
                            <option value="Obat Cacing">Obat Cacing</option>
                            <option value="Tablet Tambah Darah (Bumil)">Tablet Tambah Darah (Bumil)</option>
                        </select>
                    </div>

                    <div>
                        <label class="block font-bold text-slate-700 mb-1">Tanggal Pemberian</label>
                        <input type="date" name="tanggal_pemberian" value="{{ old('tanggal_pemberian', date('Y-m-d')) }}" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                    </div>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Status Pemberian</label>
                    <select name="status" class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="selesai">Selesai Diberikan</option>
                        <option value="terjadwal">Terjadwal</option>
                        <option value="terlewat">Terlewat</option>
                    </select>
                </div>

                <div>
                    <label class="block font-bold text-slate-700 mb-1">Catatan Tambahan</label>
                    <textarea name="catatan" rows="3" placeholder="Contoh: Tidak ada demam pasca suntik, batch vaksin #..." class="w-full px-3.5 py-2.5 rounded-xl border border-slate-200 focus:ring-2 focus:ring-teal-500 outline-none">{{ old('catatan') }}</textarea>
                </div>

                <button type="submit" class="w-full py-3.5 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs rounded-2xl shadow-md transition-all text-center">
                    Simpan Riwayat Imunisasi
                </button>
            </form>

        </div>
    </div>
</x-app-layout>

