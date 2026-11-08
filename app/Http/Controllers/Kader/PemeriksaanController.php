<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kader\Imunisasi;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Kader\Pemeriksaan;
use App\Models\Kader\PemeriksaanBalita;
use App\Models\Kader\PemeriksaanBumil;
use App\Models\Kader\PemeriksaanLansia;
use App\Models\Peserta\Peserta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PemeriksaanController extends Controller
{
    public function index(Request $request): View
    {
        $validated = $request->validate([
            'search' => ['nullable', 'string', 'max:100'],
            'kategori' => ['nullable', 'in:balita,ibu_hamil,lansia'],
        ]);
        $posyanduId = $request->user()->posyandu_id;
        $kategoriOptions = [
            '' => 'Semua',
            'balita' => 'Bayi & Balita',
            'ibu_hamil' => 'Ibu Hamil',
            'lansia' => 'Lansia',
        ];
        $jumlahPerKategori = Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->whereIn('kategori', ['balita', 'ibu_hamil', 'lansia'])
            ->select('kategori')
            ->selectRaw('count(*) as jumlah')
            ->groupBy('kategori')
            ->pluck('jumlah', 'kategori');
        $query = Peserta::query()
            ->forPosyandu($posyanduId)
            ->with('keluarga:id,no_kk')
            ->whereIn('kategori', ['balita', 'ibu_hamil', 'lansia']);

        if ($kategori = $validated['kategori'] ?? null) {
            $query->where('kategori', $kategori);
        }

        if ($search = $validated['search'] ?? null) {
            $query->where('nama', 'like', '%'.$search.'%');
        }

        $peserta = $query
            ->orderBy('nama')
            ->paginate(15)
            ->withQueryString();

        return view('kader.pemeriksaan.index', [
            'peserta' => $peserta,
            'kategoriOptions' => $kategoriOptions,
            'jumlahPerKategori' => $jumlahPerKategori,
            'kategoriTerpilih' => $validated['kategori'] ?? '',
            'search' => $validated['search'] ?? '',
        ]);
    }

    public function create(Request $request): View
    {
        $kegiatan = null;
        if ($request->filled('kegiatan_id')) {
            $kegiatan = JadwalKegiatan::query()
                ->forPosyandu($request->user()->posyandu_id)
                ->findOrFail($request->integer('kegiatan_id'));

            abort_unless(
                $kegiatan->tanggal_kegiatan?->isToday() && $kegiatan->status === 'berlangsung',
                403,
                'Pemeriksaan hanya dapat dicatat pada pertemuan Posyandu yang sedang berlangsung.',
            );
        }

        $peserta = Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->with('keluarga')
            ->orderBy('nama')
            ->get();

        $selectedParticipantId = $request->old('peserta_id', $request->input('peserta_id'));
        $pesertaTerpilih = filled($selectedParticipantId)
            ? $peserta->firstWhere('id', (int) $selectedParticipantId)
            : null;

        abort_if(filled($selectedParticipantId) && ! $pesertaTerpilih, 404);
        if ($kegiatan && $pesertaTerpilih) {
            abort_unless(
                $kegiatan->peserta()
                    ->whereKey($pesertaTerpilih->id)
                    ->wherePivot('status_kehadiran', 'hadir')
                    ->exists(),
                403,
                'Peserta harus dicatat hadir sebelum pemeriksaan pertemuan.',
            );
        }

        return view('kader.pemeriksaan.create', compact('peserta', 'pesertaTerpilih', 'kegiatan'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'peserta_id' => ['required', 'integer', 'exists:peserta,id'],
            'kegiatan_id' => ['nullable', 'integer', 'exists:kegiatan,id'],
        ])['peserta_id'];

        $peserta = Peserta::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($validated);

        $kegiatan = null;
        if ($request->filled('kegiatan_id')) {
            $kegiatan = JadwalKegiatan::query()
                ->forPosyandu($request->user()->posyandu_id)
                ->findOrFail($request->integer('kegiatan_id'));

            abort_unless(
                $kegiatan->tanggal_kegiatan?->isToday() && $kegiatan->status === 'berlangsung',
                403,
                'Pemeriksaan hanya dapat dicatat pada pertemuan Posyandu yang sedang berlangsung.',
            );
            abort_unless(
                $kegiatan->peserta()
                    ->whereKey($peserta->id)
                    ->wherePivot('status_kehadiran', 'hadir')
                    ->exists(),
                403,
                'Peserta harus dicatat hadir sebelum pemeriksaan pertemuan.',
            );
        }

        $categoryRules = match ($peserta->kategori) {
            'balita' => [
                'berat_badan' => ['required', 'numeric', 'gt:0'],
                'tinggi_badan' => ['nullable', 'numeric', 'gt:0'],
                'lingkar_kepala' => ['nullable', 'numeric', 'gt:0'],
                'perkembangan' => ['nullable', 'string', 'max:255'],
                'status_gizi' => ['nullable', 'string', 'max:255'],
                'jenis_vaksin' => ['nullable', 'string', 'max:255'],
                'vitamin' => ['nullable', 'string', 'max:255'],
                'obat_cacing' => ['nullable', 'boolean'],
            ],
            'ibu_hamil' => [
                'berat_badan' => ['required', 'numeric', 'gt:0'],
                'usia_kehamilan' => ['nullable', 'integer', 'between:1,45'],
                'tekanan_darah' => ['nullable', 'string', 'max:10'],
                'tinggi_fundus' => ['nullable', 'numeric', 'gt:0'],
                'denyut_jantung_janin' => ['nullable', 'integer', 'gt:0'],
                'catatan_kehamilan' => ['nullable', 'string'],
            ],
            'lansia' => [
                'berat_badan' => ['required', 'numeric', 'gt:0'],
                'tekanan_darah' => ['nullable', 'string', 'max:10'],
                'gula_darah' => ['nullable', 'numeric', 'gt:0'],
                'kolesterol' => ['nullable', 'numeric', 'gt:0'],
                'asam_urat' => ['nullable', 'numeric', 'gt:0'],
                'catatan_kesehatan' => ['nullable', 'string'],
            ],
        };

        $validated = $request->validate([
            'tanggal_pemeriksaan' => ['required', 'date', 'before_or_equal:today'],
            'keluhan' => ['nullable', 'string'],
            'catatan' => ['nullable', 'string'],
            ...$categoryRules,
        ]);

        DB::transaction(function () use ($validated, $peserta, $kegiatan): void {
            $pemeriksaan = Pemeriksaan::create([
                'peserta_id' => $peserta->id,
                'kegiatan_id' => $kegiatan?->id,
                'tanggal_pemeriksaan' => $validated['tanggal_pemeriksaan'],
                'keluhan' => $validated['keluhan'] ?? null,
                'catatan' => $validated['catatan'] ?? null,
            ]);

            if ($peserta->kategori === 'balita') {
                PemeriksaanBalita::create([
                    'pemeriksaan_id' => $pemeriksaan->id,
                    'berat_badan' => $validated['berat_badan'],
                    'tinggi_badan' => $validated['tinggi_badan'] ?? null,
                    'lingkar_kepala' => $validated['lingkar_kepala'] ?? null,
                    'perkembangan' => $validated['perkembangan'] ?? null,
                    'catatan_gizi' => $validated['status_gizi'] ?? null,
                ]);
            } elseif ($peserta->kategori === 'ibu_hamil') {
                PemeriksaanBumil::create([
                    'pemeriksaan_id' => $pemeriksaan->id,
                    'usia_kehamilan' => $validated['usia_kehamilan'] ?? null,
                    'berat_badan' => $validated['berat_badan'],
                    'tekanan_darah' => $validated['tekanan_darah'] ?? null,
                    'tinggi_fundus' => $validated['tinggi_fundus'] ?? null,
                    'denyut_jantung_janin' => $validated['denyut_jantung_janin'] ?? null,
                    'catatan_kehamilan' => $validated['catatan_kehamilan'] ?? null,
                ]);
            } elseif ($peserta->kategori === 'lansia') {
                PemeriksaanLansia::create([
                    'pemeriksaan_id' => $pemeriksaan->id,
                    'tekanan_darah' => $validated['tekanan_darah'] ?? null,
                    'gula_darah' => $validated['gula_darah'] ?? null,
                    'kolesterol' => $validated['kolesterol'] ?? null,
                    'asam_urat' => $validated['asam_urat'] ?? null,
                    'berat_badan' => $validated['berat_badan'],
                    'catatan_kesehatan' => $validated['catatan_kesehatan'] ?? null,
                ]);
            }

            $imunisasi = array_filter([
                $validated['jenis_vaksin'] ?? null,
                $validated['vitamin'] ?? null,
                ! empty($validated['obat_cacing']) ? 'Obat cacing' : null,
            ]);

            if ($imunisasi !== []) {
                Imunisasi::create([
                    'peserta_id' => $peserta->id,
                    'jenis_imunisasi' => $validated['jenis_vaksin'] ?? 'Vitamin / obat cacing',
                    'tanggal_pemberian' => $validated['tanggal_pemeriksaan'],
                    'status' => 'selesai',
                    'catatan' => implode(', ', array_diff($imunisasi, [$validated['jenis_vaksin'] ?? null])),
                ]);
            }
        });

        return redirect()
            ->route('kader.pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil disimpan.');
    }

    public function show(Request $request, string $id): View
    {
        $pemeriksaan = Pemeriksaan::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->with(['peserta.keluarga', 'balita', 'bumil', 'lansia', 'tindakLanjut'])
            ->findOrFail($id);

        return view('kader.pemeriksaan.show', compact('pemeriksaan'));
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $pemeriksaan = Pemeriksaan::query()
            ->forPosyandu($request->user()->posyandu_id)
            ->findOrFail($id);

        $pemeriksaan->delete();

        return redirect()
            ->route('kader.pemeriksaan.index')
            ->with('success', 'Data pemeriksaan berhasil dihapus.');
    }
}
