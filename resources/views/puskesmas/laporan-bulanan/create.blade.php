<x-app-layout>
    <div class="mx-auto max-w-3xl space-y-6">
        <div>
            <a href="{{ route('puskesmas.laporan-bulanan.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Kembali ke laporan</a>
            <h1 class="mt-3 text-2xl font-bold text-slate-800">Buat Laporan Bulanan</h1>
            <p class="mt-1 text-sm text-slate-500">Sistem akan menyusun draf dari laporan pertemuan Posyandu yang sudah selesai pada periode tersebut.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">{{ $errors->first() }}</div>
        @endif

        <form method="POST" action="{{ route('puskesmas.laporan-bulanan.store') }}" class="space-y-5 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            @csrf
            <div>
                <label for="bulan" class="mb-2 block text-sm font-semibold text-slate-700">Bulan laporan</label>
                <select id="bulan" name="bulan" required class="w-full rounded-xl border-slate-300">
                    @foreach (range(1, 12) as $month)
                        <option value="{{ $month }}" @selected((int) old('bulan', $defaultMonth) === $month)>
                            {{ \Illuminate\Support\Carbon::createFromDate($defaultYear, $month, 1)->translatedFormat('F') }}
                        </option>
                    @endforeach
                </select>
                @error('bulan')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div>
                <label for="tahun" class="mb-2 block text-sm font-semibold text-slate-700">Tahun</label>
                <input id="tahun" name="tahun" type="number" min="2000" max="{{ now()->year }}" value="{{ old('tahun', $defaultYear) }}" required class="w-full rounded-xl border-slate-300">
                @error('tahun')<p class="mt-1 text-sm text-rose-700">{{ $message }}</p>@enderror
            </div>
            <div class="rounded-xl border border-teal-100 bg-teal-50 p-4 text-sm text-teal-900">
                Rekap otomatis hanya memasukkan pertemuan berstatus selesai. Draf dapat ditinjau dan diperbarui sebelum dikirim; laporan yang sudah dikirim tidak dapat diubah.
            </div>
            <button type="submit" class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-800">Buat Draf</button>
        </form>
    </div>
</x-app-layout>
