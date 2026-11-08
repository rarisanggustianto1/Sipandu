<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <a href="{{ route('kader.jadwal.index') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Kembali ke jadwal</a>
                <h1 class="mt-3 text-2xl font-black text-slate-800">{{ $jadwal->nama_kegiatan }}</h1>
                <p class="mt-1 text-sm text-slate-500">{{ $jadwal->posyandu->nama_posyandu }} · {{ $jadwal->tanggal_kegiatan?->translatedFormat('l, d F Y') }} · {{ $jadwal->waktu_mulai ?? 'Waktu belum ditentukan' }}</p>
                @if ($jadwal->deskripsi)
                    <p class="mt-2 text-sm text-slate-600">{{ $jadwal->deskripsi }}</p>
                @endif
            </div>
            <span class="rounded-full px-3 py-1.5 text-xs font-bold {{ $jadwal->status === 'berlangsung' ? 'bg-teal-100 text-teal-800' : ($jadwal->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800') }}">
                {{ ucfirst($jadwal->status) }}
            </span>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif
        @if ($errors->any())
            <div class="rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-800">{{ $errors->first() }}</div>
        @endif

        <section class="grid gap-4 sm:grid-cols-3">
            <div class="rounded-2xl border border-slate-200 bg-white p-5"><p class="text-sm text-slate-500">Peserta hadir</p><p class="mt-2 text-3xl font-black text-slate-800">{{ $jadwal->peserta_hadir_count }}</p></div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5"><p class="text-sm text-slate-500">Pemeriksaan tercatat</p><p class="mt-2 text-3xl font-black text-slate-800">{{ $jadwal->pemeriksaans_count }}</p></div>
            <div class="rounded-2xl border border-slate-200 bg-white p-5"><p class="text-sm text-slate-500">Petugas hadir</p><p class="mt-2 text-3xl font-black text-slate-800">{{ $jadwal->petugas_hadir_count }}</p></div>
        </section>

        @if ($jadwal->status === 'terjadwal' && $jadwal->tanggal_kegiatan?->isToday())
            <form method="POST" action="{{ route('kader.jadwal.start', $jadwal) }}" class="rounded-2xl border border-teal-200 bg-teal-50 p-5">
                @csrf
                <h2 class="font-bold text-teal-950">Pertemuan hari ini siap dimulai</h2>
                <p class="mt-1 text-sm text-teal-800">Mulai pertemuan untuk membuka absensi petugas, absensi peserta, dan pencatatan pemeriksaan.</p>
                <button class="mt-4 rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-800">Mulai Pertemuan</button>
            </form>
        @elseif ($pertemuanAktif)
            <section class="flex flex-wrap items-center justify-between gap-4 rounded-2xl border border-teal-200 bg-teal-50 p-5">
                <div>
                    <h2 class="font-bold text-teal-950">Pertemuan sedang berlangsung</h2>
                    <p class="mt-1 text-sm text-teal-800">Catat kehadiran dan pemeriksaan peserta pada pertemuan ini.</p>
                </div>
                <div class="flex flex-wrap gap-2">
                    @unless ($jadwal->petugas->contains('id', auth()->id()))
                        <form method="POST" action="{{ route('kader.jadwal.check-in', $jadwal) }}">
                            @csrf
                            <button class="rounded-xl border border-teal-700 px-4 py-2.5 text-sm font-bold text-teal-800 hover:bg-teal-100">Absen sebagai Petugas</button>
                        </form>
                    @endunless
                    <a href="{{ route('kader.pemeriksaan.create', ['kegiatan_id' => $jadwal->id]) }}" class="rounded-xl bg-teal-700 px-4 py-2.5 text-sm font-bold text-white hover:bg-teal-800">Catat Pemeriksaan</a>
                    <form method="POST" action="{{ route('kader.jadwal.finish', $jadwal) }}" onsubmit="return confirm('Selesaikan pertemuan dan tutup pencatatan?')">
                        @csrf
                        <button class="rounded-xl bg-slate-800 px-4 py-2.5 text-sm font-bold text-white hover:bg-slate-900">Selesaikan Pertemuan</button>
                    </form>
                </div>
            </section>

            <form method="POST" action="{{ route('kader.jadwal.attendance', $jadwal) }}" class="space-y-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                @csrf
                @method('PUT')
                <div>
                    <h2 class="font-bold text-slate-800">Absensi peserta</h2>
                    <p class="mt-1 text-sm text-slate-500">Pilih hadir atau tidak hadir untuk setiap peserta. Pemeriksaan tidak diperlukan untuk mencatat kehadiran.</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200 text-sm">
                        <thead class="bg-slate-50 text-left text-xs uppercase text-slate-500">
                            <tr><th class="px-4 py-3">Nama peserta</th><th class="px-4 py-3">Kategori</th><th class="px-4 py-3">Kehadiran</th><th class="px-4 py-3">Pemeriksaan</th></tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($peserta as $anggota)
                                @php($statusKehadiran = $kehadiran[$anggota->id] ?? null)
                                <tr>
                                    <td class="px-4 py-3 font-semibold text-slate-800">{{ $anggota->nama }}</td>
                                    <td class="px-4 py-3 text-slate-600">{{ $anggota->label_kategori }}</td>
                                    <td class="px-4 py-3">
                                        <select name="kehadiran[{{ $anggota->id }}]" class="rounded-lg border-slate-300 text-sm">
                                            <option value="">Belum dicatat</option>
                                            <option value="hadir" @selected($statusKehadiran === 'hadir')>Hadir</option>
                                            <option value="tidak_hadir" @selected($statusKehadiran === 'tidak_hadir')>Tidak hadir</option>
                                        </select>
                                    </td>
                                    <td class="px-4 py-3">
                                        @if ($statusKehadiran === 'hadir')
                                            <a href="{{ route('kader.pemeriksaan.create', ['peserta_id' => $anggota->id, 'kegiatan_id' => $jadwal->id]) }}" class="text-xs font-semibold text-teal-700 hover:underline">Catat pemeriksaan</a>
                                        @else
                                            <span class="text-xs text-slate-400">Tandai hadir dulu</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="px-4 py-8 text-center text-slate-500">Belum ada peserta pada Posyandu ini.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <button class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-800">Simpan Absensi Peserta</button>
            </form>
        @else
            <div class="rounded-2xl border border-slate-200 bg-white p-5 text-sm text-slate-600">
                Absensi dan pemeriksaan hanya tersedia saat pertemuan berlangsung pada tanggal yang dijadwalkan.
            </div>
        @endif

        <section class="grid gap-6 lg:grid-cols-2">
            <div class="space-y-3">
                <h2 class="font-bold text-slate-800">Petugas yang hadir</h2>
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    @forelse ($jadwal->petugas as $petugas)
                        <p class="border-b border-slate-100 py-2 text-sm text-slate-700 last:border-0">{{ $petugas->name }}</p>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada petugas yang melakukan absensi.</p>
                    @endforelse
                </div>
            </div>
            <div class="space-y-3">
                <h2 class="font-bold text-slate-800">Pemeriksaan pada pertemuan ini</h2>
                <div class="rounded-2xl border border-slate-200 bg-white p-4">
                    @forelse ($jadwal->pemeriksaans as $pemeriksaan)
                        <p class="border-b border-slate-100 py-2 text-sm text-slate-700 last:border-0">{{ $pemeriksaan->peserta->nama }} · {{ $pemeriksaan->tanggal_pemeriksaan?->format('d M Y') }}</p>
                    @empty
                        <p class="text-sm text-slate-500">Belum ada pemeriksaan tercatat di pertemuan ini.</p>
                    @endforelse
                </div>
            </div>
        </section>
    </div>
</x-app-layout>
