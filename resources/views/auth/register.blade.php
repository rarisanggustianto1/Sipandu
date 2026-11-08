@extends('layouts.app')

@section('title', '— Daftar Keluarga')

@section('content')
<div class="mx-auto max-w-xl rounded-lg bg-white p-6 shadow">
    <h1 class="mb-2 text-xl font-bold">Daftar akun keluarga</h1>
    <p class="mb-6 text-sm text-gray-600">
        Buat akun dengan Nomor KK dan password pilihan Anda. Setelah masuk, tambahkan anggota keluarga agar dapat dimonitoring oleh Kader Posyandu.
    </p>

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="no_kk" class="block text-sm font-medium">Nomor KK</label>
            <input id="no_kk" name="no_kk" type="text" value="{{ old('no_kk') }}" required maxlength="16"
                   inputmode="numeric" pattern="[0-9]{16}" autocomplete="off"
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
            @error('no_kk') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="nama_kepala_keluarga" class="block text-sm font-medium">Nama kepala keluarga</label>
            <input id="nama_kepala_keluarga" name="nama_kepala_keluarga" type="text"
                   value="{{ old('nama_kepala_keluarga') }}" required autocomplete="name"
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
            @error('nama_kepala_keluarga') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="posyandu_id" class="block text-sm font-medium">Posyandu</label>
            <select id="posyandu_id" name="posyandu_id" required class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Pilih Posyandu</option>
                @foreach ($posyandu as $item)
                    <option value="{{ $item->id }}" @selected(old('posyandu_id') == $item->id)>
                        {{ $item->nama_posyandu }} · {{ $item->kelurahan }}
                    </option>
                @endforeach
            </select>
            @error('posyandu_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="alamat" class="block text-sm font-medium">Alamat</label>
            <textarea id="alamat" name="alamat" rows="2" required
                      class="mt-1 w-full rounded-md border-gray-300 shadow-sm">{{ old('alamat') }}</textarea>
            @error('alamat') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="no_telepon" class="block text-sm font-medium">Nomor telepon (opsional)</label>
            <input id="no_telepon" name="no_telepon" type="tel" value="{{ old('no_telepon') }}"
                   autocomplete="tel" class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
            @error('no_telepon') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium">Buat password</label>
            <input id="password" name="password" type="password" required autocomplete="new-password"
                   class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
            @error('password') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium">Ulangi password</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                   autocomplete="new-password" class="mt-1 w-full rounded-md border-gray-300 shadow-sm">
        </div>

        <button type="submit" class="w-full rounded-md bg-blue-600 px-4 py-2 font-semibold text-white hover:bg-blue-700">
            Daftar akun keluarga
        </button>
    </form>

    <p class="mt-4 text-sm text-gray-600">
        Sudah memiliki akun?
        <a href="{{ route('login') }}" class="font-semibold text-blue-600 hover:text-blue-700">Masuk</a>.
    </p>
</div>
@endsection
