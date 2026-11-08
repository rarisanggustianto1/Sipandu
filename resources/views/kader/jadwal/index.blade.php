<x-app-layout>
    <div class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Jadwal & Agenda Kegiatan Posyandu</h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Jadwal ditetapkan Puskesmas. Buka pertemuan aktif untuk absensi dan pemeriksaan.</p>
                </div>
            </div>

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- TABEL / CARD DAFTAR JADWAL -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5">Tanggal</th>
                                <th class="p-3.5">Nama Kegiatan</th>
                                <th class="p-3.5">Posyandu</th>
                                <th class="p-3.5">Lokasi</th>
                                <th class="p-3.5">Waktu Mulai</th>
                                <th class="p-3.5">Status</th>
                                <th class="p-3.5">Hadir / Periksa</th>
                                <th class="p-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($jadwal as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-3.5 font-bold text-slate-800">
                                        {{ $item->tanggal_kegiatan?->translatedFormat('l, d M Y') ?? '-' }}
                                    </td>
                                    <td class="p-3.5 font-semibold text-teal-800">{{ $item->nama_kegiatan }}</td>
                                    <td class="p-3.5">{{ $item->posyandu->nama_posyandu ?? '-' }}</td>
                                    <td class="p-3.5">{{ $item->lokasi ?? '-' }}</td>
                                    <td class="p-3.5">{{ $item->waktu_mulai ? substr((string) $item->waktu_mulai, 0, 5) : '-' }}</td>
                                    <td class="p-3.5">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold 
                                            {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : ($item->status === 'berlangsung' ? 'bg-teal-100 text-teal-800' : 'bg-amber-100 text-amber-800') }}">
                                            {{ ucfirst($item->status ?? 'terjadwal') }}
                                        </span>
                                    </td>
                                    <td class="p-3.5">
                                        {{ $item->peserta_hadir_count }} peserta · {{ $item->pemeriksaans_count }} pemeriksaan
                                        <span class="block text-[10px] text-slate-500">{{ $item->petugas_hadir_count }} petugas hadir</span>
                                    </td>
                                    <td class="p-3.5 text-center">
                                        <a href="{{ route('kader.jadwal.show', $item) }}" class="font-semibold text-teal-700 hover:underline">
                                            {{ $item->tanggal_kegiatan?->isToday() && in_array($item->status, ['terjadwal', 'berlangsung'], true) ? 'Buka pertemuan →' : 'Lihat laporan →' }}
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-8 text-center text-slate-400">
                                        Belum ada jadwal. Hubungi Puskesmas untuk membuat jadwal Posyandu.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($jadwal->hasPages())
                    <div class="pt-4 border-t border-slate-100">
                        {{ $jadwal->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>
