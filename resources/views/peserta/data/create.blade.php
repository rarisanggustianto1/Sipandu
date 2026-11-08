<x-app-layout>
    <div class="mx-auto max-w-2xl space-y-5 px-4 py-8 sm:px-6 lg:px-8">
        <div>
            <a href="{{ route('peserta.keluarga.index') }}" class="text-sm font-semibold text-teal-800">← Kembali ke keluarga</a>
            <h1 class="mt-3 text-2xl font-black text-slate-800">Daftarkan anggota keluarga</h1>
            <p class="mt-1 text-sm text-slate-500">Anggota akan otomatis terhubung ke keluarga dan Posyandu pada akun Anda.</p>
        </div>
        <form method="POST" action="{{ route('peserta.data.store') }}" class="grid gap-4 rounded-2xl bg-white p-6 shadow-sm sm:grid-cols-2">
            @csrf
            <div>
                <label for="nik" class="mb-1 block text-sm font-medium">NIK</label>
                <input id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" required class="w-full rounded-xl border-slate-200">
                @error('nik') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="nama" class="mb-1 block text-sm font-medium">Nama lengkap</label>
                <input id="nama" name="nama" value="{{ old('nama') }}" required class="w-full rounded-xl border-slate-200">
                @error('nama') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="jenis_kelamin" class="mb-1 block text-sm font-medium">Jenis kelamin</label>
                <select id="jenis_kelamin" name="jenis_kelamin" required class="w-full rounded-xl border-slate-200">
                    <option value="">Pilih</option>
                    <option value="L" @selected(old('jenis_kelamin') === 'L')>Laki-laki</option>
                    <option value="P" @selected(old('jenis_kelamin') === 'P')>Perempuan</option>
                </select>
            </div>
            <div>
                <label for="tanggal_lahir" class="mb-1 block text-sm font-medium">Tanggal lahir</label>
                <input id="tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}" required class="w-full rounded-xl border-slate-200">
            </div>
            <div>
                <label for="kategori" class="mb-1 block text-sm font-medium">Kategori</label>
                <select id="kategori" name="kategori" required class="w-full rounded-xl border-slate-200">
                    <option value="balita" @selected(old('kategori') === 'balita')>Bayi / balita</option>
                    <option value="ibu_hamil" @selected(old('kategori') === 'ibu_hamil')>Ibu hamil</option>
                    <option value="lansia" @selected(old('kategori') === 'lansia')>Lansia</option>
                </select>
            </div>
            <div class="flex items-end sm:col-span-2">
                <button class="w-full rounded-xl bg-teal-700 px-5 py-3 font-bold text-white">Simpan anggota keluarga</button>
            </div>
        </form>
    </div>
</x-app-layout>
