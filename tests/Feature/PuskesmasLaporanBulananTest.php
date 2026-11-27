<?php

namespace Tests\Feature;

use App\Models\Dinas\DinasKesehatan;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Peserta\Peserta;
use App\Models\Puskesmas\LaporanBulanan;
use App\Models\Puskesmas\Posyandu;
use App\Models\Puskesmas\Puskesmas;
use App\Models\User;
use Carbon\Carbon;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PuskesmasLaporanBulananTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
        Carbon::setTestNow('2026-11-26 10:00:00');
    }

    protected function tearDown(): void
    {
        Carbon::setTestNow();
        parent::tearDown();
    }

    public function test_puskesmas_reviews_and_submits_a_monthly_meeting_snapshot_to_dinas(): void
    {
        $puskesmas = User::where('email', 'puskesmas@gmail.com')->firstOrFail();
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $participant = Peserta::where('nama', 'Sinta')->firstOrFail();
        $posyandu = Posyandu::where('nama_posyandu', 'Posyandu Demo')->firstOrFail();

        $completedMeeting = $this->createMeeting($posyandu, 'Posyandu November', '2026-11-08', 'selesai');
        $completedMeeting->peserta()->attach($participant->id, ['status_kehadiran' => 'hadir']);
        $completedMeeting->petugas()->attach($kader->id, ['status_kehadiran' => 'hadir']);
        $completedMeeting->pemeriksaans()->create([
            'peserta_id' => $participant->id,
            'tanggal_pemeriksaan' => '2026-11-08',
        ]);
        $this->createMeeting($posyandu, 'Agenda belum terlaksana', '2026-11-20', 'terjadwal');

        $this->actingAs($puskesmas)
            ->post(route('puskesmas.laporan-bulanan.store'), [
                'tahun' => 2026,
                'bulan' => 11,
            ])
            ->assertRedirect();

        $report = LaporanBulanan::query()->firstOrFail();
        $this->assertSame([
            'jumlah_pertemuan' => 1,
            'peserta_hadir' => 1,
            'pemeriksaan' => 1,
            'petugas_hadir' => 1,
        ], $report->data['ringkasan']);

        $this->actingAs($puskesmas)
            ->get(route('puskesmas.laporan-bulanan.show', $report))
            ->assertOk()
            ->assertSee('Posyandu November')
            ->assertDontSee('Agenda belum terlaksana');

        $this->actingAs($puskesmas)
            ->put(route('puskesmas.laporan-bulanan.update', $report), [
                'catatan' => 'Rekap bulanan sudah ditinjau.',
            ])
            ->assertRedirect(route('puskesmas.laporan-bulanan.show', $report));

        $this->actingAs($puskesmas)
            ->post(route('puskesmas.laporan-bulanan.submit', $report))
            ->assertRedirect(route('puskesmas.laporan-bulanan.show', $report));

        $report->refresh();
        $this->assertSame('dikirim', $report->status);
        $this->assertSame('Rekap bulanan sudah ditinjau.', $report->catatan);
        $this->assertNotNull($report->dikirim_pada);

        $dinas = User::where('email', 'dinas@gmail.com')->firstOrFail();
        $this->actingAs($dinas)
            ->get(route('dinas.laporan.index'))
            ->assertOk()
            ->assertSee('Puskesmas Demo');

        $this->actingAs($dinas)
            ->get(route('dinas.laporan.show', $report))
            ->assertOk()
            ->assertSee('Rekap bulanan sudah ditinjau.')
            ->assertSee('Kunjungan peserta hadir');

        $this->actingAs($puskesmas)
            ->put(route('puskesmas.laporan-bulanan.update', $report), ['catatan' => 'Diubah setelah dikirim'])
            ->assertNotFound();
    }

    public function test_puskesmas_and_dinas_cannot_access_another_regions_monthly_report(): void
    {
        $outsideDistrict = DinasKesehatan::create(['nama_dinas' => 'Dinas Wilayah Lain']);
        $outsidePuskesmas = Puskesmas::create([
            'dinas_kesehatan_id' => $outsideDistrict->id,
            'nama_puskesmas' => 'Puskesmas Wilayah Lain',
            'alamat' => 'Alamat Puskesmas Lain',
            'kecamatan' => 'Kecamatan Lain',
        ]);
        $outsideReport = LaporanBulanan::query()->create([
            'puskesmas_id' => $outsidePuskesmas->id,
            'tahun' => 2026,
            'bulan' => 10,
            'data' => ['ringkasan' => [], 'posyandu' => []],
            'status' => 'dikirim',
            'dikirim_pada' => now(),
        ]);

        $puskesmas = User::where('email', 'puskesmas@gmail.com')->firstOrFail();
        $this->actingAs($puskesmas)
            ->get(route('puskesmas.laporan-bulanan.show', $outsideReport))
            ->assertNotFound();

        $dinas = User::where('email', 'dinas@gmail.com')->firstOrFail();
        $this->actingAs($dinas)
            ->get(route('dinas.laporan.show', $outsideReport))
            ->assertNotFound();

        $this->actingAs($dinas)
            ->get(route('dinas.laporan.index'))
            ->assertDontSee('Puskesmas Wilayah Lain');
    }

    public function test_monthly_report_period_cannot_be_future_or_created_twice(): void
    {
        $puskesmas = User::where('email', 'puskesmas@gmail.com')->firstOrFail();

        $this->actingAs($puskesmas)
            ->post(route('puskesmas.laporan-bulanan.store'), [
                'tahun' => 2026,
                'bulan' => 11,
            ])
            ->assertRedirect();

        $report = LaporanBulanan::query()->firstOrFail();
        $this->actingAs($puskesmas)
            ->post(route('puskesmas.laporan-bulanan.store'), [
                'tahun' => 2026,
                'bulan' => 11,
            ])
            ->assertRedirect(route('puskesmas.laporan-bulanan.show', $report));

        $this->actingAs($puskesmas)
            ->from(route('puskesmas.laporan-bulanan.create'))
            ->post(route('puskesmas.laporan-bulanan.store'), [
                'tahun' => 2026,
                'bulan' => 12,
            ])
            ->assertRedirect(route('puskesmas.laporan-bulanan.create'))
            ->assertSessionHasErrors('bulan');

        $this->assertDatabaseCount('laporan_bulanan', 1);
    }

    private function createMeeting(Posyandu $posyandu, string $name, string $date, string $status): JadwalKegiatan
    {
        return JadwalKegiatan::query()->create([
            'posyandu_id' => $posyandu->id,
            'nama_kegiatan' => $name,
            'jenis_kegiatan' => 'Posyandu Rutin',
            'tanggal_kegiatan' => $date,
            'status' => $status,
        ]);
    }
}
