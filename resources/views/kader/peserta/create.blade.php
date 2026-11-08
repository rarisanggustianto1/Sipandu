<x-app-layout>
    <div class="mx-auto max-w-3xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <div>
            <a href="{{ route('kader.peserta.index') }}" class="text-sm font-semibold text-teal-800">← Kembali ke peserta</a>
            <h1 class="mt-3 text-2xl font-black text-slate-800">Daftarkan peserta dan akun keluarga</h1>
            <p class="mt-1 text-sm text-slate-500">Akun keluarga menggunakan Nomor KK dan password awal yang Anda atur.</p>
        </div>

        <form method="POST" action="{{ route('kader.peserta.store') }}" x-data="{ buatKeluarga: true, perluPassword: true, pilihKeluarga(event) { const option = event.target.selectedOptions[0]; this.buatKeluarga = !option.value; this.perluPassword = !option.value || option.dataset.hasAccount !== 'true'; } }" class="space-y-6 rounded-2xl bg-white p-6 shadow-sm">
            @csrf

            <section class="space-y-4">
                <h2 class="font-bold text-slate-800">Data keluarga</h2>
                <label class="block text-sm font-medium text-slate-700" for="keluarga_id">Pilih keluarga yang sudah terdaftar (opsional)</label>
                <select id="keluarga_id" name="keluarga_id" @change="pilihKeluarga($event)" class="w-full rounded-xl border-slate-200">
                    <option value="">Daftarkan keluarga baru</option>
                    @foreach ($keluargaList as $keluarga)
                        <option value="{{ $keluarga->id }}" data-has-account="{{ $keluarga->user ? 'true' : 'false' }}" @selected(old('keluarga_id') == $keluarga->id)>
                            {{ $keluarga->nama_kepala_keluarga }} · {{ $keluarga->no_kk }}{{ $keluarga->user ? ' (akun aktif)' : ' (belum ada akun)' }}
                        </option>
                    @endforeach
                </select>

                <div x-show="buatKeluarga" class="grid gap-4 sm:grid-cols-2">
                    <div>
                        <label for="no_kk" class="mb-1 block text-sm font-medium">Nomor KK</label>
                        <input id="no_kk" name="no_kk" value="{{ old('no_kk') }}" maxlength="16" inputmode="numeric" :required="buatKeluarga" class="w-full rounded-xl border-slate-200">
                        @error('no_kk') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="nama_kepala_keluarga" class="mb-1 block text-sm font-medium">Nama kepala keluarga</label>
                        <input id="nama_kepala_keluarga" name="nama_kepala_keluarga" value="{{ old('nama_kepala_keluarga') }}" :required="buatKeluarga" class="w-full rounded-xl border-slate-200">
                        @error('nama_kepala_keluarga') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label for="alamat" class="mb-1 block text-sm font-medium">Alamat</label>
                        <textarea id="alamat" name="alamat" rows="2" :required="buatKeluarga" class="w-full rounded-xl border-slate-200">{{ old('alamat') }}</textarea>
                        @error('alamat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label for="no_telepon" class="mb-1 block text-sm font-medium">Nomor telepon</label>
                        <input id="no_telepon" name="no_telepon" value="{{ old('no_telepon') }}" class="w-full rounded-xl border-slate-200">
                    </div>
                </div>

                <div x-show="perluPassword">
                    <label for="password" class="mb-1 block text-sm font-medium">Password awal akun keluarga</label>
                    <input id="password" name="password" type="password" minlength="8" :required="perluPassword" autocomplete="new-password" class="w-full rounded-xl border-slate-200">
                    <p class="mt-1 text-xs text-slate-500">Berikan password ini kepada keluarga. Keluarga dapat menggantinya melalui halaman profil.</p>
                    @error('password') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                    <label for="password_confirmation" class="mb-1 mt-3 block text-sm font-medium">Ulangi password awal</label>
                    <input id="password_confirmation" name="password_confirmation" type="password" minlength="8" :required="perluPassword" autocomplete="new-password" class="w-full rounded-xl border-slate-200">
                </div>
            </section>

            <section class="grid gap-4 border-t border-slate-100 pt-5 sm:grid-cols-2">
                <h2 class="sm:col-span-2 font-bold text-slate-800">Anggota keluarga pertama</h2>
                <div>
                    <label for="nik" class="mb-1 block text-sm font-medium">NIK</label>
                    <input id="nik" name="nik" value="{{ old('nik') }}" maxlength="16" inputmode="numeric" required class="w-full rounded-xl border-slate-200">
                    @error('nik') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="nama" class="mb-1 block text-sm font-medium">Nama anggota</label>
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
            </section>

            <button class="w-full rounded-xl bg-teal-700 px-5 py-3 font-bold text-white hover:bg-teal-800">Simpan data dan akun keluarga</button>
        </form>
    </div>
</x-app-layout>
