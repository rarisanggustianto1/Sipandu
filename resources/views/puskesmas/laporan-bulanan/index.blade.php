<x-app-layout>
    <div class="mx-auto max-w-7xl space-y-6">
        <div class="flex flex-wrap items-end justify-between gap-4">
            <div>
                <h1 class="text-2xl font-bold text-slate-800">Laporan Bulanan ke Dinas</h1>
                <p class="mt-1 text-sm text-slate-500">Tinjau rekap kegiatan Posyandu sebelum mengirimkannya ke Dinas Kesehatan.</p>
            </div>
            <a href="{{ route('puskesmas.laporan-bulanan.create') }}" class="rounded-xl bg-teal-700 px-5 py-2.5 text-sm font-bold text-white hover:bg-teal-800">
                Buat Laporan Bulanan
            </a>
        </div>

        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm font-semibold text-emerald-800">{{ session('success') }}</div>
        @endif

        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200 text-sm">
                    <thead class="bg-slate-50 text-left text-xs uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Periode</th>
                            <th class="px-5 py-3">Pertemuan</th>
                            <th class="px-5 py-3">Peserta Hadir</th>
                            <th class="px-5 py-3">Pemeriksaan</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($reports as $report)
                            <tr>
                                <td class="whitespace-nowrap px-5 py-4 font-semibold text-slate-800">{{ \Illuminate\Support\Carbon::createFromDate($report->tahun, $report->bulan, 1)->translatedFormat('F Y') }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ number_format($report->data['ringkasan']['jumlah_pertemuan'] ?? 0, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ number_format($report->data['ringkasan']['peserta_hadir'] ?? 0, 0, ',', '.') }}</td>
                                <td class="px-5 py-4 text-slate-600">{{ number_format($report->data['ringkasan']['pemeriksaan'] ?? 0, 0, ',', '.') }}</td>
                                <td class="px-5 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs font-bold {{ $report->status === 'dikirim' ? 'bg-emerald-100 text-emerald-800' : 'bg-amber-100 text-amber-800' }}">
                                        {{ $report->status === 'dikirim' ? 'Terkirim' : 'Draf' }}
                                    </span>
                                </td>
                                <td class="px-5 py-4">
                                    <a href="{{ route('puskesmas.laporan-bulanan.show', $report) }}" class="font-semibold text-teal-700 hover:underline">Tinjau laporan</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-12 text-center text-slate-500">
                                    Belum ada laporan bulanan. Buat laporan untuk menyusun rekap kegiatan yang sudah selesai.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if ($reports->hasPages())
                <div class="border-t border-slate-100 p-4">{{ $reports->links() }}</div>
            @endif
        </div>
    </div>
</x-app-layout>
