<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6 px-4 py-8 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <a href="{{ route('peserta.dashboard') }}" class="text-sm font-semibold text-teal-700 hover:underline">← Kembali ke dashboard</a>
                <h1 class="mt-3 text-2xl font-black text-slate-800">Jadwal Posyandu</h1>
                <p class="mt-1 text-sm text-slate-500">
                    Jadwal mendatang untuk {{ $keluarga->posyandu->nama_posyandu }}.
                </p>
            </div>
        </div>

        <section class="space-y-4" aria-label="Daftar jadwal Posyandu mendatang">
            @forelse ($jadwal as $item)
                <article class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                    <div class="flex flex-wrap items-start justify-between gap-3">
                        <div>
                            <p class="text-sm font-semibold text-teal-800">
                                {{ $item->tanggal_kegiatan?->translatedFormat('l, d F Y') ?? '-' }}
                            </p>
                            <h2 class="mt-1 text-lg font-bold text-slate-900">{{ $item->nama_kegiatan }}</h2>
                            <p class="mt-1 text-sm text-slate-600">{{ $item->jenis_kegiatan }}</p>
                        </div>
                        <span class="rounded-full px-3 py-1 text-xs font-semibold {{ $item->status === 'berlangsung' ? 'bg-teal-100 text-teal-800' : 'bg-amber-100 text-amber-800' }}">
                            {{ $item->status === 'berlangsung' ? 'Sedang berlangsung' : 'Akan datang' }}
                        </span>
                    </div>

                    <dl class="mt-4 flex flex-wrap gap-x-6 gap-y-2 text-sm text-slate-600">
                        <div>
                            <dt class="inline font-semibold text-slate-700">Waktu:</dt>
                            <dd class="inline">{{ $item->waktu_mulai ? substr((string) $item->waktu_mulai, 0, 5) : 'Belum ditentukan' }}</dd>
                        </div>
                        <div>
                            <dt class="inline font-semibold text-slate-700">Lokasi:</dt>
                            <dd class="inline">{{ $item->lokasi ?: 'Belum ditentukan' }}</dd>
                        </div>
                    </dl>

                    @if ($item->deskripsi)
                        <p class="mt-3 border-t border-slate-100 pt-3 text-sm text-slate-600">{{ $item->deskripsi }}</p>
                    @endif
                </article>
            @empty
                <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-8 text-center">
                    <h2 class="font-bold text-slate-800">Belum ada jadwal mendatang</h2>
                    <p class="mt-2 text-sm text-slate-500">Jadwal dari Puskesmas akan muncul di sini setelah ditetapkan untuk Posyandu Anda.</p>
                </div>
            @endforelse
        </section>

        @if ($jadwal->hasPages())
            <div class="border-t border-slate-200 pt-4">
                {{ $jadwal->links() }}
            </div>
        @endif
    </div>
</x-app-layout>
