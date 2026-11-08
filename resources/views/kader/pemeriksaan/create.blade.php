<x-app-layout>
    <div
        class="mx-auto max-w-5xl space-y-6 px-4 py-8 sm:px-6 lg:px-8"
        x-data="{
            kategori: @js($pesertaTerpilih?->kategori ?? ''),
            pesertaNama: @js($pesertaTerpilih?->nama ?? ''),
            pesertaKk: @js($pesertaTerpilih?->keluarga?->no_kk ?? ''),
            pesertaUsia: @js($pesertaTerpilih?->usia),
            pilihPeserta(event) {
                const option = event.target.selectedOptions[0];
                this.kategori = option?.dataset.kategori ?? '';
                this.pesertaNama = option?.dataset.nama ?? '';
                this.pesertaKk = option?.dataset.kk ?? '';
                this.pesertaUsia = option?.dataset.usia ?? '';
            }
        }"
    >
        <header class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
            <div>
                <a href="{{ isset($kegiatan) ? route('kader.jadwal.show', $kegiatan) : route('kader.pemeriksaan.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-teal-800 hover:text-teal-950">
                    <span aria-hidden="true">←</span> {{ isset($kegiatan) ? 'Kembali ke pertemuan' : 'Kembali ke daftar peserta' }}
                </a>
                <h1 class="mt-3 text-2xl font-black tracking-tight text-slate-900 sm:text-3xl">Catat pemeriksaan</h1>
                <p class="mt-1 max-w-2xl text-sm leading-6 text-slate-600">
                    Formulir menyesuaikan kategori peserta. Hasil pemeriksaan akan tercatat pada riwayat kesehatan dan monitoring Posyandu Anda.
                </p>
                @if (isset($kegiatan))
                    <div class="mt-3 rounded-xl border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-900">
                        Pemeriksaan ini akan tercatat pada <strong>{{ $kegiatan->nama_kegiatan }}</strong>
                        · {{ $kegiatan->tanggal_kegiatan?->format('d M Y') }}.
                    </div>
                @endif
            </div>
            <div class="inline-flex w-fit items-center gap-2 rounded-full border border-teal-200 bg-teal-50 px-3 py-1.5 text-xs font-semibold text-teal-900">
                <span class="h-2 w-2 rounded-full bg-teal-600"></span>
                Posyandu {{ auth()->user()->posyandu?->nama_posyandu ?? 'Anda' }}
            </div>
        </header>

        @if ($peserta->isEmpty())
            <section class="rounded-2xl border border-amber-200 bg-amber-50 p-6 text-amber-950">
                <h2 class="font-bold">Belum ada peserta di Posyandu ini</h2>
                <p class="mt-1 text-sm leading-6">Daftarkan peserta terlebih dahulu sebelum mencatat pemeriksaan.</p>
                <a href="{{ route('kader.peserta.create') }}" class="mt-4 inline-flex rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-teal-800">
                    Daftarkan peserta
                </a>
            </section>
        @else
            <form method="POST" action="{{ route('kader.pemeriksaan.store') }}" class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
                @csrf
                @if (isset($kegiatan))
                    <input type="hidden" name="kegiatan_id" value="{{ $kegiatan->id }}">
                @endif

                @if ($errors->any())
                    <div class="border-b border-rose-200 bg-rose-50 px-5 py-4 text-sm text-rose-900 sm:px-7" role="alert">
                        <p class="font-bold">Periksa kembali data yang diisi.</p>
                        <ul class="mt-1 list-inside list-disc space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="space-y-8 p-5 sm:p-7">
                    <section class="space-y-4">
                        <div class="flex items-start gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-teal-100 text-sm font-black text-teal-800">1</span>
                            <div>
                                <h2 class="font-bold text-slate-900">Pilih peserta dan tanggal</h2>
                                <p class="text-sm text-slate-500">Daftar hanya berisi peserta dari Posyandu Anda.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 sm:pl-11">
                            <div class="sm:col-span-2">
                                <label for="peserta_id" class="mb-1.5 block text-sm font-semibold text-slate-700">Peserta <span class="text-rose-600">*</span></label>
                                <select
                                    id="peserta_id"
                                    name="peserta_id"
                                    required
                                    @change="pilihPeserta($event)"
                                    class="w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600"
                                >
                                    <option value="">Pilih nama peserta</option>
                                    @foreach ($peserta as $anggota)
                                        <option
                                            value="{{ $anggota->id }}"
                                            data-kategori="{{ $anggota->kategori }}"
                                            data-nama="{{ $anggota->nama }}"
                                            data-kk="{{ $anggota->keluarga->no_kk }}"
                                            data-usia="{{ $anggota->usia }}"
                                            @selected(old('peserta_id', $pesertaTerpilih?->id) == $anggota->id)
                                        >
                                            {{ $anggota->nama }} · {{ $anggota->label_kategori }} · KK {{ $anggota->keluarga->no_kk }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('peserta_id') <p class="mt-1.5 text-sm text-rose-700">{{ $message }}</p> @enderror

                                <div x-cloak x-show="kategori !== ''" class="mt-3 flex flex-wrap items-center gap-2 rounded-xl border border-teal-100 bg-teal-50 px-4 py-3 text-sm">
                                    <span class="font-bold text-slate-900" x-text="pesertaNama"></span>
                                    <span class="rounded-full bg-white px-2.5 py-1 text-xs font-semibold text-teal-800">
                                        <span x-show="kategori === 'balita'">Bayi / balita</span>
                                        <span x-show="kategori === 'ibu_hamil'">Ibu hamil</span>
                                        <span x-show="kategori === 'lansia'">Lansia</span>
                                    </span>
                                    <span class="text-xs text-slate-600">KK <span x-text="pesertaKk"></span> · Usia <span x-text="pesertaUsia"></span> tahun</span>
                                </div>
                            </div>

                            <div>
                                <label for="tanggal_pemeriksaan" class="mb-1.5 block text-sm font-semibold text-slate-700">Tanggal pemeriksaan <span class="text-rose-600">*</span></label>
                                <input
                                    id="tanggal_pemeriksaan"
                                    name="tanggal_pemeriksaan"
                                    type="date"
                                    max="{{ now()->toDateString() }}"
                                    value="{{ old('tanggal_pemeriksaan', now()->toDateString()) }}"
                                    required
                                    class="w-full rounded-xl border-slate-300 px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600"
                                >
                                @error('tanggal_pemeriksaan') <p class="mt-1.5 text-sm text-rose-700">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </section>

                    <fieldset
                        x-cloak
                        x-show="kategori === 'balita'"
                        :disabled="kategori !== 'balita'"
                        class="space-y-5 border-t border-slate-200 pt-6"
                    >
                        <legend class="sr-only">Pemeriksaan bayi atau balita</legend>
                        <div class="flex items-start gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-sky-100 text-sm font-black text-sky-800">2</span>
                            <div>
                                <h2 class="font-bold text-slate-900">Pertumbuhan bayi / balita</h2>
                                <p class="text-sm text-slate-500">Catat pengukuran dan perkembangan sesuai hasil pemeriksaan hari ini.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 sm:pl-11">
                            <div>
                                <label for="berat_badan_balita" class="mb-1.5 block text-sm font-semibold text-slate-700">Berat badan <span class="text-rose-600">*</span></label>
                                <div class="relative">
                                    <input id="berat_badan_balita" name="berat_badan" type="number" step="0.01" min="0.1" value="{{ old('berat_badan') }}" required class="w-full rounded-xl border-slate-300 px-3 py-3 pr-12 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">kg</span>
                                </div>
                                @error('berat_badan') <p class="mt-1.5 text-sm text-rose-700">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tinggi_badan" class="mb-1.5 block text-sm font-semibold text-slate-700">Panjang / tinggi badan</label>
                                <div class="relative">
                                    <input id="tinggi_badan" name="tinggi_badan" type="number" step="0.01" min="0.1" value="{{ old('tinggi_badan') }}" class="w-full rounded-xl border-slate-300 px-3 py-3 pr-12 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">cm</span>
                                </div>
                            </div>
                            <div>
                                <label for="lingkar_kepala" class="mb-1.5 block text-sm font-semibold text-slate-700">Lingkar kepala</label>
                                <div class="relative">
                                    <input id="lingkar_kepala" name="lingkar_kepala" type="number" step="0.01" min="0.1" value="{{ old('lingkar_kepala') }}" class="w-full rounded-xl border-slate-300 px-3 py-3 pr-12 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">cm</span>
                                </div>
                            </div>
                            <div>
                                <label for="status_gizi" class="mb-1.5 block text-sm font-semibold text-slate-700">Status gizi</label>
                                <select id="status_gizi" name="status_gizi" class="w-full rounded-xl border-slate-300 bg-white px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <option value="">Pilih status</option>
                                    @foreach (['Gizi baik', 'Gizi kurang', 'Gizi buruk', 'Berisiko gizi lebih', 'Gizi lebih', 'Obesitas'] as $status)
                                        <option value="{{ $status }}" @selected(old('status_gizi') === $status)>{{ $status }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="perkembangan" class="mb-1.5 block text-sm font-semibold text-slate-700">Catatan tumbuh kembang</label>
                                <textarea id="perkembangan" name="perkembangan" rows="2" placeholder="Contoh: perkembangan sesuai usia, hasil skrining, atau hal yang perlu dipantau" class="w-full rounded-xl border-slate-300 px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">{{ old('perkembangan') }}</textarea>
                            </div>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 sm:ml-11">
                            <h3 class="text-sm font-bold text-slate-800">Layanan tambahan</h3>
                            <p class="mt-1 text-xs text-slate-500">Isi bila vaksin, vitamin, atau obat cacing diberikan pada kunjungan ini.</p>
                            <div class="mt-3 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label for="jenis_vaksin" class="mb-1.5 block text-sm font-medium text-slate-700">Imunisasi / vaksin</label>
                                    <input id="jenis_vaksin" name="jenis_vaksin" value="{{ old('jenis_vaksin') }}" placeholder="Contoh: DPT-HB-Hib 1" class="w-full rounded-xl border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                </div>
                                <div>
                                    <label for="vitamin" class="mb-1.5 block text-sm font-medium text-slate-700">Vitamin</label>
                                    <input id="vitamin" name="vitamin" value="{{ old('vitamin') }}" placeholder="Contoh: Vitamin A" class="w-full rounded-xl border-slate-300 px-3 py-2.5 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                </div>
                                <label class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white px-3 py-2.5 text-sm text-slate-700 sm:col-span-2">
                                    <input type="checkbox" name="obat_cacing" value="1" @checked(old('obat_cacing')) class="rounded border-slate-300 text-teal-700 focus:ring-teal-600">
                                    Obat cacing diberikan
                                </label>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset
                        x-cloak
                        x-show="kategori === 'ibu_hamil'"
                        :disabled="kategori !== 'ibu_hamil'"
                        class="space-y-5 border-t border-slate-200 pt-6"
                    >
                        <legend class="sr-only">Pemeriksaan ibu hamil</legend>
                        <div class="flex items-start gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-rose-100 text-sm font-black text-rose-800">2</span>
                            <div>
                                <h2 class="font-bold text-slate-900">Pemeriksaan ibu hamil</h2>
                                <p class="text-sm text-slate-500">Catat kondisi ibu dan pemantauan kehamilan.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 sm:pl-11">
                            <div>
                                <label for="berat_badan_bumil" class="mb-1.5 block text-sm font-semibold text-slate-700">Berat badan <span class="text-rose-600">*</span></label>
                                <div class="relative">
                                    <input id="berat_badan_bumil" name="berat_badan" type="number" step="0.01" min="0.1" value="{{ old('berat_badan') }}" required class="w-full rounded-xl border-slate-300 px-3 py-3 pr-12 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">kg</span>
                                </div>
                                @error('berat_badan') <p class="mt-1.5 text-sm text-rose-700">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="usia_kehamilan" class="mb-1.5 block text-sm font-semibold text-slate-700">Usia kehamilan</label>
                                <div class="relative">
                                    <input id="usia_kehamilan" name="usia_kehamilan" type="number" min="1" max="45" value="{{ old('usia_kehamilan') }}" class="w-full rounded-xl border-slate-300 px-3 py-3 pr-16 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">minggu</span>
                                </div>
                            </div>
                            <div>
                                <label for="tekanan_darah_bumil" class="mb-1.5 block text-sm font-semibold text-slate-700">Tekanan darah</label>
                                <input id="tekanan_darah_bumil" name="tekanan_darah" value="{{ old('tekanan_darah') }}" placeholder="Contoh: 120/80" class="w-full rounded-xl border-slate-300 px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                            </div>
                            <div>
                                <label for="tinggi_fundus" class="mb-1.5 block text-sm font-semibold text-slate-700">Tinggi fundus</label>
                                <div class="relative">
                                    <input id="tinggi_fundus" name="tinggi_fundus" type="number" step="0.01" min="0.1" value="{{ old('tinggi_fundus') }}" class="w-full rounded-xl border-slate-300 px-3 py-3 pr-12 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">cm</span>
                                </div>
                            </div>
                            <div>
                                <label for="denyut_jantung_janin" class="mb-1.5 block text-sm font-semibold text-slate-700">Denyut jantung janin</label>
                                <div class="relative">
                                    <input id="denyut_jantung_janin" name="denyut_jantung_janin" type="number" min="1" value="{{ old('denyut_jantung_janin') }}" class="w-full rounded-xl border-slate-300 px-3 py-3 pr-14 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">bpm</span>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="catatan_kehamilan" class="mb-1.5 block text-sm font-semibold text-slate-700">Catatan kehamilan</label>
                                <textarea id="catatan_kehamilan" name="catatan_kehamilan" rows="2" placeholder="Catatan pemeriksaan atau anjuran untuk kunjungan berikutnya" class="w-full rounded-xl border-slate-300 px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">{{ old('catatan_kehamilan') }}</textarea>
                            </div>
                        </div>
                    </fieldset>

                    <fieldset
                        x-cloak
                        x-show="kategori === 'lansia'"
                        :disabled="kategori !== 'lansia'"
                        class="space-y-5 border-t border-slate-200 pt-6"
                    >
                        <legend class="sr-only">Pemeriksaan lansia</legend>
                        <div class="flex items-start gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-violet-100 text-sm font-black text-violet-800">2</span>
                            <div>
                                <h2 class="font-bold text-slate-900">Pemeriksaan lansia</h2>
                                <p class="text-sm text-slate-500">Catat tanda vital dan pemeriksaan kesehatan yang dilakukan.</p>
                            </div>
                        </div>

                        <div class="grid gap-4 sm:grid-cols-2 sm:pl-11">
                            <div>
                                <label for="berat_badan_lansia" class="mb-1.5 block text-sm font-semibold text-slate-700">Berat badan <span class="text-rose-600">*</span></label>
                                <div class="relative">
                                    <input id="berat_badan_lansia" name="berat_badan" type="number" step="0.01" min="0.1" value="{{ old('berat_badan') }}" required class="w-full rounded-xl border-slate-300 px-3 py-3 pr-12 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">kg</span>
                                </div>
                                @error('berat_badan') <p class="mt-1.5 text-sm text-rose-700">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="tekanan_darah_lansia" class="mb-1.5 block text-sm font-semibold text-slate-700">Tekanan darah</label>
                                <input id="tekanan_darah_lansia" name="tekanan_darah" value="{{ old('tekanan_darah') }}" placeholder="Contoh: 120/80" class="w-full rounded-xl border-slate-300 px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                            </div>
                            <div>
                                <label for="gula_darah" class="mb-1.5 block text-sm font-semibold text-slate-700">Gula darah</label>
                                <div class="relative">
                                    <input id="gula_darah" name="gula_darah" type="number" step="0.01" min="0.1" value="{{ old('gula_darah') }}" class="w-full rounded-xl border-slate-300 px-3 py-3 pr-16 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">mg/dL</span>
                                </div>
                            </div>
                            <div>
                                <label for="kolesterol" class="mb-1.5 block text-sm font-semibold text-slate-700">Kolesterol</label>
                                <div class="relative">
                                    <input id="kolesterol" name="kolesterol" type="number" step="0.01" min="0.1" value="{{ old('kolesterol') }}" class="w-full rounded-xl border-slate-300 px-3 py-3 pr-16 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">mg/dL</span>
                                </div>
                            </div>
                            <div>
                                <label for="asam_urat" class="mb-1.5 block text-sm font-semibold text-slate-700">Asam urat</label>
                                <div class="relative">
                                    <input id="asam_urat" name="asam_urat" type="number" step="0.01" min="0.1" value="{{ old('asam_urat') }}" class="w-full rounded-xl border-slate-300 px-3 py-3 pr-16 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">
                                    <span class="pointer-events-none absolute inset-y-0 right-3 flex items-center text-sm text-slate-500">mg/dL</span>
                                </div>
                            </div>
                            <div class="sm:col-span-2">
                                <label for="catatan_kesehatan" class="mb-1.5 block text-sm font-semibold text-slate-700">Catatan kesehatan</label>
                                <textarea id="catatan_kesehatan" name="catatan_kesehatan" rows="2" placeholder="Catatan pemeriksaan atau anjuran tindak lanjut" class="w-full rounded-xl border-slate-300 px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">{{ old('catatan_kesehatan') }}</textarea>
                            </div>
                        </div>
                    </fieldset>

                    <div x-cloak x-show="kategori === ''" class="rounded-xl border border-dashed border-slate-300 bg-slate-50 px-4 py-6 text-center">
                        <p class="font-semibold text-slate-700">Pilih peserta untuk memulai</p>
                        <p class="mt-1 text-sm text-slate-500">Kolom pemeriksaan akan menyesuaikan kategori peserta.</p>
                    </div>

                    <section class="space-y-4 border-t border-slate-200 pt-6">
                        <div class="flex items-start gap-3">
                            <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-slate-100 text-sm font-black text-slate-700">3</span>
                            <div>
                                <h2 class="font-bold text-slate-900">Keluhan dan catatan</h2>
                                <p class="text-sm text-slate-500">Bagian ini opsional untuk semua kategori peserta.</p>
                            </div>
                        </div>
                        <div class="grid gap-4 sm:grid-cols-2 sm:pl-11">
                            <div>
                                <label for="keluhan" class="mb-1.5 block text-sm font-semibold text-slate-700">Keluhan peserta</label>
                                <textarea id="keluhan" name="keluhan" rows="3" placeholder="Keluhan yang disampaikan peserta" class="w-full rounded-xl border-slate-300 px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">{{ old('keluhan') }}</textarea>
                                @error('keluhan') <p class="mt-1.5 text-sm text-rose-700">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label for="catatan" class="mb-1.5 block text-sm font-semibold text-slate-700">Catatan / rekomendasi kader</label>
                                <textarea id="catatan" name="catatan" rows="3" placeholder="Anjuran atau tindak lanjut pemeriksaan" class="w-full rounded-xl border-slate-300 px-3 py-3 text-sm shadow-sm focus:border-teal-600 focus:ring-teal-600">{{ old('catatan') }}</textarea>
                                @error('catatan') <p class="mt-1.5 text-sm text-rose-700">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </section>
                </div>

                <footer class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-5 py-4 sm:flex-row sm:items-center sm:justify-between sm:px-7">
                    <p class="text-xs text-slate-500"><span class="text-rose-600">*</span> Wajib diisi untuk kategori peserta yang dipilih.</p>
                    <div class="flex flex-col gap-3 sm:flex-row">
                        <a href="{{ route('kader.peserta.index') }}" class="inline-flex justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-bold text-slate-700 hover:bg-slate-100">
                            Batal
                        </a>
                        <button
                            type="submit"
                            :disabled="kategori === ''"
                            class="inline-flex justify-center rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-teal-800 focus:outline-none focus:ring-2 focus:ring-teal-600 focus:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50"
                        >
                            Simpan pemeriksaan
                        </button>
                    </div>
                </footer>
            </form>
        @endif
    </div>
</x-app-layout>
