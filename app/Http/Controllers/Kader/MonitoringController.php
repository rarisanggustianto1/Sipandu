<?php

namespace App\Http\Controllers\Kader;

use App\Http\Controllers\Controller;
use App\Models\Kader\Pemeriksaan;
use App\Models\Kader\PemeriksaanBalita;
use App\Models\Kader\PemeriksaanBumil;
use App\Models\Kader\PemeriksaanLansia;
use App\Models\Peserta\Peserta;
use Illuminate\Database\Eloquent\Collection as EloquentCollection;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class MonitoringController extends Controller
{
    private const CATEGORIES = [
        'balita' => 'Bayi / Balita',
        'ibu_hamil' => 'Ibu Hamil',
        'lansia' => 'Lansia',
    ];

    public function index(Request $request): View
    {
        $validated = $request->validate([
            'periode' => ['nullable', 'in:minggu_ini,bulan_ini,3_bulan'],
        ]);
        $periode = $validated['periode'] ?? 'bulan_ini';
        [$tanggalMulai, $tanggalSelesai] = $this->rentangPeriode($periode);
        $posyanduId = $request->user()->posyandu_id;
        $peserta = Peserta::query()
            ->forPosyandu($posyanduId)
            ->get(['id', 'kategori']);
        $pemeriksaan = $this->pemeriksaanPosyandu($posyanduId, $tanggalMulai, $tanggalSelesai);
        $prioritas = $this->pesertaPrioritas($this->pemeriksaanPosyandu($posyanduId));
        $prioritasIds = $prioritas->pluck('peserta.id')->all();
        $diperiksaIds = $pemeriksaan->pluck('peserta_id')->unique();

        $kategori = collect(self::CATEGORIES)->map(function (string $label, string $key) use ($peserta, $pemeriksaan, $prioritas, $prioritasIds, $diperiksaIds): array {
            $pemeriksaanKategori = $pemeriksaan
                ->filter(fn (Pemeriksaan $item): bool => $item->peserta?->kategori === $key);
            $points = $this->titikPertemuan($pemeriksaanKategori, $key);
            $anggotaKategori = $peserta->where('kategori', $key);
            $jumlahPrioritas = $prioritas
                ->where('kategori', $key)
                ->pluck('peserta.id')
                ->unique()
                ->count();
            $jumlahBaik = $anggotaKategori
                ->whereIn('id', $diperiksaIds->all())
                ->reject(fn (Peserta $item): bool => in_array($item->id, $prioritasIds, true))
                ->count();
            $jumlahPeserta = $anggotaKategori->count();

            return [
                'key' => $key,
                'label' => $label,
                'jumlah_peserta' => $jumlahPeserta,
                'sudah_diperiksa' => $pemeriksaanKategori->pluck('peserta_id')->unique()->count(),
                'jumlah_baik' => $jumlahBaik,
                'jumlah_pemantauan' => max(0, $jumlahPeserta - $jumlahBaik - $jumlahPrioritas),
                'jumlah_prioritas' => $jumlahPrioritas,
                'pertemuan_terakhir' => $points->last(),
                'arah_tren' => $this->arahTren($points),
            ];
        });

        $ringkasan = [
            'jumlah_peserta' => $peserta->count(),
            'jumlah_baik' => $kategori->sum('jumlah_baik'),
            'jumlah_pemantauan' => $kategori->sum('jumlah_pemantauan'),
            'jumlah_prioritas' => $kategori->sum('jumlah_prioritas'),
            'jumlah_diperiksa' => $diperiksaIds->count(),
        ];
        $ringkasan['persentase_diperiksa'] = $ringkasan['jumlah_peserta'] > 0
            ? (int) round($ringkasan['jumlah_diperiksa'] / $ringkasan['jumlah_peserta'] * 100)
            : 0;
        $namaPeriode = match ($periode) {
            'minggu_ini' => 'Minggu Ini',
            '3_bulan' => '3 Bulan',
            default => 'Bulan Ini',
        };

        return view('kader.monitoring.index', compact('kategori', 'ringkasan', 'periode', 'namaPeriode'));
    }

    public function show(Request $request, string $kategori): View
    {
        abort_unless(array_key_exists($kategori, self::CATEGORIES), 404);
        $validated = $request->validate([
            'periode' => ['nullable', 'in:minggu_ini,bulan_ini,3_bulan'],
        ]);
        $periode = $validated['periode'] ?? 'bulan_ini';
        [$tanggalMulai, $tanggalSelesai] = $this->rentangPeriode($periode);
        $posyanduId = $request->user()->posyandu_id;

        $pemeriksaan = $this->pemeriksaanPosyandu($posyanduId, $tanggalMulai, $tanggalSelesai)
            ->filter(fn (Pemeriksaan $item): bool => $item->peserta?->kategori === $kategori)
            ->values();
        $points = $this->titikPertemuan($pemeriksaan, $kategori);
        $prioritas = $this->pesertaPrioritas($this->pemeriksaanPosyandu($posyanduId))
            ->filter(fn (array $item): bool => $item['kategori'] === $kategori)
            ->values();
        $jumlahPeserta = Peserta::query()
            ->forPosyandu($posyanduId)
            ->where('kategori', $kategori)
            ->count();
        $jumlahDiperiksa = $pemeriksaan->pluck('peserta_id')->unique()->count();
        $namaPeriode = match ($periode) {
            'minggu_ini' => 'Minggu Ini',
            '3_bulan' => '3 Bulan',
            default => 'Bulan Ini',
        };

        return view('kader.monitoring.show', [
            'kategori' => $kategori,
            'labelKategori' => self::CATEGORIES[$kategori],
            'jumlahPeserta' => $jumlahPeserta,
            'jumlahDiperiksa' => $jumlahDiperiksa,
            'jumlahPertemuan' => $points->count(),
            'points' => $points,
            'prioritas' => $prioritas,
            'grafik' => $this->definisiGrafik($kategori),
            'periode' => $periode,
            'namaPeriode' => $namaPeriode,
        ]);
    }

    /**
     * @return array{string, string}
     */
    private function rentangPeriode(string $periode): array
    {
        $sekarang = now();
        $mulai = match ($periode) {
            'minggu_ini' => $sekarang->copy()->startOfWeek(),
            '3_bulan' => $sekarang->copy()->subMonths(2)->startOfMonth(),
            default => $sekarang->copy()->startOfMonth(),
        };

        return [$mulai->toDateString(), $sekarang->toDateString()];
    }

    /**
     * @return EloquentCollection<int, Pemeriksaan>
     */
    private function pemeriksaanPosyandu(?int $posyanduId, ?string $tanggalMulai = null, ?string $tanggalSelesai = null): EloquentCollection
    {
        $query = Pemeriksaan::query()
            ->forPosyandu($posyanduId)
            ->with([
                'peserta:id,nama,kategori',
                'balita',
                'bumil',
                'lansia',
                'kegiatan:id,nama_kegiatan,tanggal_kegiatan',
            ])
            ->orderBy('tanggal_pemeriksaan')
            ->orderBy('id');

        if ($tanggalMulai !== null && $tanggalSelesai !== null) {
            $query->whereBetween('tanggal_pemeriksaan', [$tanggalMulai, $tanggalSelesai]);
        }

        return $query->get();
    }

    /**
     * @param  Collection<int, Pemeriksaan>  $pemeriksaan
     * @return Collection<int, array{kategori: string, peserta: Peserta, tanggal: string, pemeriksaan: Pemeriksaan, keluhan: ?string, catatan: ?string, alasan: list<string>}>
     */
    private function pesertaPrioritas(Collection $pemeriksaan): Collection
    {
        return $pemeriksaan
            ->groupBy('peserta_id')
            ->map(function (Collection $riwayat): ?array {
                $riwayat = $riwayat
                    ->sortByDesc(fn (Pemeriksaan $item): string => $item->tanggal_pemeriksaan?->format('Ymd').sprintf('%010d', $item->id))
                    ->values();
                $terbaru = $riwayat->first();

                if (! $terbaru instanceof Pemeriksaan || ! $terbaru->peserta) {
                    return null;
                }

                $sebelumnya = $riwayat->get(1);
                $kategori = $terbaru->peserta->kategori;
                $detailTerbaru = $this->detailKategori($terbaru, $kategori);
                $detailSebelumnya = $sebelumnya instanceof Pemeriksaan
                    ? $this->detailKategori($sebelumnya, $kategori)
                    : null;
                $alasan = [];

                if (in_array($kategori, ['balita', 'ibu_hamil', 'lansia'], true)
                    && $detailTerbaru
                    && $detailSebelumnya
                    && is_numeric($detailTerbaru->berat_badan ?? null)
                    && is_numeric($detailSebelumnya->berat_badan ?? null)
                    && (float) $detailTerbaru->berat_badan < (float) $detailSebelumnya->berat_badan) {
                    $alasan[] = 'Berat badan menurun dibanding pemeriksaan sebelumnya.';
                }

                if ($kategori === 'balita' && preg_match('/\b(buruk|kurang|sangat kurang)\b/i', (string) ($detailTerbaru->catatan_gizi ?? ''))) {
                    $alasan[] = 'Catatan status gizi perlu ditinjau.';
                }

                if (in_array($kategori, ['ibu_hamil', 'lansia'], true)) {
                    $tekananDarah = $this->angkaTekananDarah($detailTerbaru->tekanan_darah ?? null);

                    if ($tekananDarah && ($tekananDarah['sistolik'] >= 140 || $tekananDarah['diastolik'] >= 90)) {
                        $alasan[] = 'Tekanan darah perlu ditinjau tenaga kesehatan ('.$detailTerbaru->tekanan_darah.').';
                    }
                }

                if ($alasan === []) {
                    return null;
                }

                return [
                    'kategori' => $kategori,
                    'peserta' => $terbaru->peserta,
                    'tanggal' => $terbaru->tanggal_pemeriksaan?->format('d M Y') ?? '-',
                    'pemeriksaan' => $terbaru,
                    'keluhan' => $terbaru->keluhan,
                    'catatan' => $terbaru->catatan,
                    'alasan' => $alasan,
                ];
            })
            ->filter()
            ->sortBy('peserta.nama')
            ->values();
    }

    /**
     * @param  Collection<int, Pemeriksaan>  $pemeriksaan
     * @return Collection<int, array{label: string, tanggal: string, jumlah_peserta: int, values: array<string, float|null>}>
     */
    private function titikPertemuan(Collection $pemeriksaan, string $kategori): Collection
    {
        $definisi = $this->definisiGrafik($kategori);

        return $pemeriksaan
            ->groupBy(fn (Pemeriksaan $item): string => $item->kegiatan_id
                ? 'kegiatan-'.$item->kegiatan_id
                : 'tanggal-'.$item->tanggal_pemeriksaan?->format('Y-m-d'))
            ->map(function (Collection $pertemuan) use ($definisi): array {
                $pemeriksaanPeserta = $pertemuan
                    ->groupBy('peserta_id')
                    ->map(fn (Collection $riwayat): Pemeriksaan => $riwayat->last());
                $pertama = $pertemuan->first();
                $tanggal = $pertama->kegiatan?->tanggal_kegiatan ?? $pertama->tanggal_pemeriksaan;
                $values = [];

                foreach ($definisi as $key => $metric) {
                    $angka = $pemeriksaanPeserta
                        ->map(fn (Pemeriksaan $item): ?float => $this->nilaiMetrik($item, $key))
                        ->filter(fn (?float $value): bool => $value !== null)
                        ->values();

                    $values[$key] = $angka->isEmpty() ? null : round($angka->avg(), 1);
                }

                return [
                    'label' => $pertama->kegiatan?->nama_kegiatan ?? 'Pemeriksaan Posyandu',
                    'tanggal' => $tanggal?->format('d M Y') ?? '-',
                    'jumlah_peserta' => $pemeriksaanPeserta->count(),
                    'values' => $values,
                    'urutan' => $tanggal?->format('Y-m-d') ?? '',
                ];
            })
            ->sortBy('urutan')
            ->values();
    }

    /**
     * @return array<string, array{label: string, unit: string}>
     */
    private function definisiGrafik(string $kategori): array
    {
        return match ($kategori) {
            'balita' => [
                'berat_badan' => ['label' => 'Grafik berat badan', 'unit' => 'kg'],
                'tinggi_badan' => ['label' => 'Grafik tinggi badan', 'unit' => 'cm'],
            ],
            'ibu_hamil' => [
                'berat_badan' => ['label' => 'Grafik berat badan', 'unit' => 'kg'],
                'usia_kehamilan' => ['label' => 'Grafik usia kehamilan', 'unit' => 'minggu'],
                'sistolik' => ['label' => 'Grafik tekanan darah sistolik', 'unit' => 'mmHg'],
                'diastolik' => ['label' => 'Grafik tekanan darah diastolik', 'unit' => 'mmHg'],
                'tinggi_fundus' => ['label' => 'Grafik tinggi fundus', 'unit' => 'cm'],
                'denyut_jantung_janin' => ['label' => 'Grafik denyut jantung janin', 'unit' => 'bpm'],
            ],
            default => [
                'berat_badan' => ['label' => 'Grafik berat badan', 'unit' => 'kg'],
                'sistolik' => ['label' => 'Grafik tekanan darah sistolik', 'unit' => 'mmHg'],
                'diastolik' => ['label' => 'Grafik tekanan darah diastolik', 'unit' => 'mmHg'],
                'gula_darah' => ['label' => 'Grafik gula darah', 'unit' => 'mg/dL'],
                'kolesterol' => ['label' => 'Grafik kolesterol', 'unit' => 'mg/dL'],
                'asam_urat' => ['label' => 'Grafik asam urat', 'unit' => 'mg/dL'],
            ],
        };
    }

    private function nilaiMetrik(Pemeriksaan $pemeriksaan, string $metric): ?float
    {
        $kategori = $pemeriksaan->peserta?->kategori;
        $detail = $this->detailKategori($pemeriksaan, $kategori);

        if ($metric === 'sistolik' || $metric === 'diastolik') {
            return $this->angkaTekananDarah($detail->tekanan_darah ?? null)[$metric] ?? null;
        }

        $value = $detail->{$metric} ?? null;

        return is_numeric($value) ? (float) $value : null;
    }

    private function detailKategori(Pemeriksaan $pemeriksaan, ?string $kategori): PemeriksaanBalita|PemeriksaanBumil|PemeriksaanLansia|null
    {
        return match ($kategori) {
            'balita' => $pemeriksaan->balita,
            'ibu_hamil' => $pemeriksaan->bumil,
            'lansia' => $pemeriksaan->lansia,
            default => null,
        };
    }

    /**
     * @return array{sistolik: float, diastolik: float}|null
     */
    private function angkaTekananDarah(?string $tekananDarah): ?array
    {
        if (! preg_match('/^\s*(\d{2,3})\s*\/\s*(\d{2,3})\s*$/', (string) $tekananDarah, $matches)) {
            return null;
        }

        return [
            'sistolik' => (float) $matches[1],
            'diastolik' => (float) $matches[2],
        ];
    }

    private function arahTren(Collection $points): ?string
    {
        $values = $points
            ->pluck('values.berat_badan')
            ->filter(fn (?float $value): bool => $value !== null)
            ->values();

        if ($values->count() < 2) {
            return null;
        }

        $selisih = $values->last() - $values->first();

        return abs($selisih) < 0.1 ? 'relatif tetap' : ($selisih > 0 ? 'cenderung meningkat' : 'cenderung menurun');
    }
}
