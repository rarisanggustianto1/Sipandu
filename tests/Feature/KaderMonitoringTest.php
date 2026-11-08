<?php

namespace Tests\Feature;

use App\Models\Kader\Pemeriksaan;
use App\Models\Kader\PemeriksaanBalita;
use App\Models\Kader\PemeriksaanBumil;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Kader\PemeriksaanLansia;
use App\Models\Peserta\Peserta;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Support\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KaderMonitoringTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        Carbon::setTestNow('2026-11-08 12:00:00');
        $this->seed(DatabaseSeeder::class);
    }

    public function test_monitoring_home_shows_category_totals_and_links_to_aggregate_details(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();

        $this->actingAs($kader)
            ->get(route('kader.monitoring.index'))
            ->assertOk()
            ->assertSee('Monitoring & Pemantauan')
            ->assertSee('Bayi / Balita')
            ->assertSee('Ibu Hamil')
            ->assertSee('Lansia')
            ->assertSee(route('kader.monitoring.show', ['kategori' => 'balita', 'periode' => 'bulan_ini']), escape: false)
            ->assertSee(route('kader.monitoring.show', ['kategori' => 'ibu_hamil', 'periode' => 'bulan_ini']), escape: false)
            ->assertSee(route('kader.monitoring.show', ['kategori' => 'lansia', 'periode' => 'bulan_ini']), escape: false)
            ->assertSee('Minggu Ini')
            ->assertSee('Bulan Ini')
            ->assertSee('3 Bulan')
            ->assertSee('Total Peserta Dipantau')
            ->assertSee('Perlu Pemantauan')
            ->assertSee('Prioritas / Intervensi')
            ->assertSee('Lihat detail')
            ->assertDontSee('👩')
            ->assertDontSee('👶')
            ->assertDontSee('👵')
            ->assertDontSee('Kartu Kesehatan');
    }

    public function test_monitoring_period_filter_changes_the_dashboard_counts(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $balita = Peserta::where('nama', 'Sinta')->firstOrFail();

        $pemeriksaan = Pemeriksaan::create([
            'peserta_id' => $balita->id,
            'tanggal_pemeriksaan' => '2026-11-05',
        ]);
        PemeriksaanBalita::create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'berat_badan' => 11.6,
        ]);

        $this->actingAs($kader)
            ->get(route('kader.monitoring.index', ['periode' => 'minggu_ini']))
            ->assertOk()
            ->assertSee('1 diperiksa pada periode minggu ini');
    }

    public function test_balita_monitoring_compares_meetings_and_prioritizes_decreasing_weight(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $balita = Peserta::where('nama', 'Sinta')->firstOrFail();
        $pemeriksaan = Pemeriksaan::create([
            'peserta_id' => $balita->id,
            'tanggal_pemeriksaan' => '2026-11-07',
            'catatan' => 'Perlu dipantau kembali',
        ]);
        PemeriksaanBalita::create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'berat_badan' => 10.8,
            'tinggi_badan' => 84,
            'catatan_gizi' => 'Normal',
        ]);

        $this->actingAs($kader)
            ->get(route('kader.monitoring.show', ['kategori' => 'balita', 'periode' => '3_bulan']))
            ->assertOk()
            ->assertSee('Perkembangan Bayi / Balita')
            ->assertSee('Grafik berat badan')
            ->assertSee('Grafik tinggi badan')
            ->assertSee('Sinta')
            ->assertSee('Berat badan menurun')
            ->assertSee('dibanding pemeriksaan sebelumnya')
            ->assertSee('Perlu dipantau kembali');
    }

    public function test_maternal_monitoring_uses_blood_pressure_parameter_and_kia_is_a_separate_route(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $bumil = Peserta::where('kategori', 'ibu_hamil')->firstOrFail();
        $pemeriksaan = Pemeriksaan::create([
            'peserta_id' => $bumil->id,
            'tanggal_pemeriksaan' => '2026-11-07',
        ]);
        PemeriksaanBumil::create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'usia_kehamilan' => 30,
            'berat_badan' => 62,
            'tekanan_darah' => '150/95',
            'tinggi_fundus' => 29,
            'denyut_jantung_janin' => 142,
        ]);

        $this->actingAs($kader)
            ->get(route('kader.monitoring.show', 'ibu_hamil'))
            ->assertOk()
            ->assertSee('Perkembangan Ibu Hamil')
            ->assertSee('Grafik tekanan darah')
            ->assertSee($bumil->nama)
            ->assertSee('Tekanan darah perlu ditinjau tenaga kesehatan');

        $this->actingAs($kader)
            ->get(route('kader.peserta.show', $bumil))
            ->assertOk()
            ->assertSee('Kartu Kesehatan')
            ->assertSee('Riwayat pemeriksaan');
    }

    public function test_scheduled_examinations_are_grouped_by_their_meeting(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $balita = Peserta::where('nama', 'Sinta')->firstOrFail();
        $jadwalPertama = JadwalKegiatan::create([
            'posyandu_id' => $kader->posyandu_id,
            'nama_kegiatan' => 'Pertemuan Monitoring Pertama',
            'jenis_kegiatan' => 'Posyandu Rutin',
            'tanggal_kegiatan' => '2026-10-15',
            'lokasi' => 'Balai Posyandu',
            'status' => 'selesai',
        ]);
        $jadwalKedua = JadwalKegiatan::create([
            'posyandu_id' => $kader->posyandu_id,
            'nama_kegiatan' => 'Pertemuan Monitoring Kedua',
            'jenis_kegiatan' => 'Posyandu Rutin',
            'tanggal_kegiatan' => '2026-11-07',
            'lokasi' => 'Balai Posyandu',
            'status' => 'selesai',
        ]);

        foreach ([
            [$jadwalPertama, '2026-10-15', 11.2],
            [$jadwalKedua, '2026-11-07', 11.8],
        ] as [$jadwal, $tanggal, $berat]) {
            $pemeriksaan = Pemeriksaan::create([
                'peserta_id' => $balita->id,
                'kegiatan_id' => $jadwal->id,
                'tanggal_pemeriksaan' => $tanggal,
            ]);
            PemeriksaanBalita::create([
                'pemeriksaan_id' => $pemeriksaan->id,
                'berat_badan' => $berat,
                'tinggi_badan' => 85,
            ]);
        }

        $this->actingAs($kader)
            ->get(route('kader.monitoring.show', ['kategori' => 'balita', 'periode' => '3_bulan']))
            ->assertOk()
            ->assertSee('Pertemuan Monitoring Pertama')
            ->assertSee('Pertemuan Monitoring Kedua')
            ->assertSee('1 peserta diperiksa');
    }

    public function test_elderly_monitoring_uses_blood_pressure_and_metabolic_measurements(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $lansia = Peserta::where('kategori', 'lansia')->firstOrFail();
        $pemeriksaan = Pemeriksaan::create([
            'peserta_id' => $lansia->id,
            'tanggal_pemeriksaan' => '2026-11-07',
        ]);
        PemeriksaanLansia::create([
            'pemeriksaan_id' => $pemeriksaan->id,
            'tekanan_darah' => '145/90',
            'gula_darah' => 130,
            'kolesterol' => 190,
            'asam_urat' => 6.5,
            'berat_badan' => 67,
        ]);

        $this->actingAs($kader)
            ->get(route('kader.monitoring.show', 'lansia'))
            ->assertOk()
            ->assertSee('Grafik tekanan darah sistolik')
            ->assertSee('Grafik gula darah')
            ->assertSee($lansia->nama)
            ->assertSee('Tekanan darah perlu ditinjau tenaga kesehatan');
    }
}
