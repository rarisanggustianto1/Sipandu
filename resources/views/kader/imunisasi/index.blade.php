<x-app-layout>
    <div class="py-8 bg-[#f4f7f6] min-h-screen">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- HEADER -->
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl font-black text-slate-800 tracking-tight">Data Imunisasi & Vitamin Posyandu</h1>
                    <p class="text-xs text-slate-500 font-medium mt-0.5">Catatan riwayat pemberian vaksin balita (Hep-B, BCG, DPT, Polio, Campak-Rubella) dan kapsul Vitamin A.</p>
                </div>
                <a href="{{ route('kader.imunisasi.create') }}" class="px-5 py-3 bg-teal-700 hover:bg-teal-800 text-white font-bold text-xs rounded-2xl shadow-md transition-all flex items-center space-x-2 self-start sm:self-auto">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    <span>Catat Imunisasi Baru</span>
                </a>
            </div>

            @if (session('success'))
                <div class="p-4 bg-emerald-50 border border-emerald-200 text-emerald-800 rounded-2xl text-xs font-semibold">
                    {{ session('success') }}
                </div>
            @endif

            <!-- TABEL DAFTAR IMUNISASI -->
            <div class="bg-white rounded-3xl p-6 border border-slate-200/80 shadow-xs space-y-4">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-xs text-slate-600">
                        <thead class="bg-slate-50 text-slate-700 font-bold uppercase tracking-wider border-b border-slate-100">
                            <tr>
                                <th class="p-3.5">Nama Peserta</th>
                                <th class="p-3.5">Kategori</th>
                                <th class="p-3.5">Jenis Imunisasi / Vitamin</th>
                                <th class="p-3.5">Tanggal Diberikan</th>
                                <th class="p-3.5">Status</th>
                                <th class="p-3.5">Catatan</th>
                                <th class="p-3.5 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($imunisasi as $item)
                                <tr class="hover:bg-slate-50 transition">
                                    <td class="p-3.5 font-bold text-slate-800">{{ $item->peserta->nama ?? '-' }}</td>
                                    <td class="p-3.5 capitalize">{{ $item->peserta->kategori ?? 'Balita' }}</td>
                                    <td class="p-3.5 font-semibold text-teal-800">{{ $item->jenis_imunisasi }}</td>
                                    <td class="p-3.5">{{ $item->tanggal_pemberian ? $item->tanggal_pemberian->format('d M Y') : '-' }}</td>
                                    <td class="p-3.5">
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold 
                                            {{ $item->status === 'selesai' ? 'bg-emerald-100 text-emerald-800' : 'bg-blue-100 text-blue-800' }}">
                                            {{ ucfirst($item->status ?? 'selesai') }}
                                        </span>
                                    </td>
                                    <td class="p-3.5 text-slate-500">{{ $item->catatan ?? '-' }}</td>
                                    <td class="p-3.5 text-center space-x-2">
                                        <a href="{{ route('kader.imunisasi.edit', $item->id) }}" class="text-teal-700 hover:underline font-semibold">Edit</a>
                                        <form action="{{ route('kader.imunisasi.destroy', $item->id) }}" method="POST" class="inline" onsubmit="return confirm('Hapus data imunisasi ini?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-rose-600 hover:underline font-semibold">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-8 text-center text-slate-400">
                                        Belum ada riwayat imunisasi yang tercatat. Klik tombol di atas untuk mencatat imunisasi.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                @if ($imunisasi->hasPages())
                    <div class="pt-4 border-t border-slate-100">
                        {{ $imunisasi->links() }}
                    </div>
                @endif
            </div>

        </div>
    </div>
</x-app-layout>

