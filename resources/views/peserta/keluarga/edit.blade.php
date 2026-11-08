<x-app-layout>
    <div class="mx-auto max-w-2xl space-y-5 px-4 py-8 sm:px-6 lg:px-8">
        <div>
            <a href="{{ route('peserta.keluarga.index') }}" class="text-sm font-semibold text-teal-800">← Kembali ke keluarga</a>
            <h1 class="mt-3 text-2xl font-black text-slate-800">Edit profil keluarga</h1>
        </div>
        <form method="POST" action="{{ route('peserta.keluarga.update', $keluarga) }}" class="space-y-4 rounded-2xl bg-white p-6 shadow-sm">
            @csrf
            @method('PUT')
            <div>
                <label for="nama_kepala_keluarga" class="mb-1 block text-sm font-medium">Nama kepala keluarga</label>
                <input id="nama_kepala_keluarga" name="nama_kepala_keluarga" value="{{ old('nama_kepala_keluarga', $keluarga->nama_kepala_keluarga) }}" required class="w-full rounded-xl border-slate-200">
                @error('nama_kepala_keluarga') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="alamat" class="mb-1 block text-sm font-medium">Alamat</label>
                <textarea id="alamat" name="alamat" rows="3" required class="w-full rounded-xl border-slate-200">{{ old('alamat', $keluarga->alamat) }}</textarea>
                @error('alamat') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label for="no_telepon" class="mb-1 block text-sm font-medium">Nomor telepon</label>
                <input id="no_telepon" name="no_telepon" value="{{ old('no_telepon', $keluarga->no_telepon) }}" class="w-full rounded-xl border-slate-200">
                @error('no_telepon') <p class="mt-1 text-xs text-red-600">{{ $message }}</p> @enderror
            </div>
            <button class="rounded-xl bg-teal-700 px-5 py-3 font-bold text-white">Simpan perubahan</button>
        </form>
    </div>
</x-app-layout>
