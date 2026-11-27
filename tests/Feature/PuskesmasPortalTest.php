<?php

namespace Tests\Feature;

use App\Models\Dinas\DinasKesehatan;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Kader\Pemeriksaan;
use App\Models\Peserta\Keluarga;
use App\Models\Peserta\Peserta;
use App\Models\Puskesmas\Posyandu;
use App\Models\Puskesmas\Puskesmas;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PuskesmasPortalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_puskesmas_can_open_a_participant_health_card_in_its_service_area(): void
    {
        $puskesmas = User::where('email', 'puskesmas@gmail.com')->firstOrFail();
        $participant = Peserta::where('nama', 'Sinta')->firstOrFail();

        $this->actingAs($puskesmas)
            ->get(route('puskesmas.peserta.show', $participant))
            ->assertOk()
            ->assertSee('Kartu Kesehatan')
            ->assertSee('Sinta')
            ->assertSee('Riwayat pemeriksaan');
    }

    public function test_puskesmas_cannot_view_or_schedule_services_for_another_puskesmas(): void
    {
        $puskesmasUser = User::where('email', 'puskesmas@gmail.com')->firstOrFail();
        $otherDistrict = DinasKesehatan::create(['nama_dinas' => 'Dinas Luar Wilayah']);
        $otherPuskesmas = Puskesmas::create([
            'dinas_kesehatan_id' => $otherDistrict->id,
            'nama_puskesmas' => 'Puskesmas Luar Wilayah',
            'alamat' => 'Alamat luar wilayah',
            'kecamatan' => 'Kecamatan luar',
        ]);
        $otherPosyandu = Posyandu::create([
            'puskesmas_id' => $otherPuskesmas->id,
            'nama_posyandu' => 'Posyandu Luar Wilayah',
            'alamat' => 'Alamat Posyandu luar wilayah',
            'kelurahan' => 'Kelurahan luar',
            'kecamatan' => 'Kecamatan luar',
        ]);
        $otherFamily = Keluarga::create([
            'posyandu_id' => $otherPosyandu->id,
            'no_kk' => '0000000000000099',
            'nama_kepala_keluarga' => 'Keluarga luar wilayah',
            'alamat' => 'Alamat keluarga luar wilayah',
        ]);
        $otherParticipant = Peserta::create([
            'keluarga_id' => $otherFamily->id,
            'nik' => '9999999999999999',
            'nama' => 'Peserta Luar Wilayah',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '2020-01-01',
            'kategori' => 'balita',
        ]);
        User::create([
            'name' => 'Kader Luar Wilayah',
            'email' => 'kader.luar@example.com',
            'password' => 'password123',
            'role' => 'kader',
            'puskesmas_id' => $otherPuskesmas->id,
            'posyandu_id' => $otherPosyandu->id,
        ]);

        $this->actingAs($puskesmasUser)
            ->get(route('puskesmas.peserta.show', $otherParticipant))
            ->assertNotFound();

        $this->actingAs($puskesmasUser)
            ->get(route('puskesmas.kader.index'))
            ->assertOk()
            ->assertSee('Kader Posyandu')
            ->assertDontSee('Kader Luar Wilayah');

        $this->actingAs($puskesmasUser)
            ->post(route('puskesmas.imunisasi.store'), [
                'peserta_id' => $otherParticipant->id,
                'jenis_imunisasi' => 'DPT',
                'tanggal_jadwal' => '2026-12-01',
                'status' => 'terjadwal',
            ])
            ->assertNotFound();

        $this->actingAs($puskesmasUser)
            ->post(route('puskesmas.kegiatan.store'), [
                'posyandu_id' => $otherPosyandu->id,
                'nama_kegiatan' => 'Kegiatan di luar wilayah',
                'jenis_kegiatan' => 'Posyandu',
                'tanggal_kegiatan' => '2026-12-01',
                'status' => 'terjadwal',
            ])
            ->assertNotFound();

        $this->assertDatabaseMissing('kegiatan', [
            'posyandu_id' => $otherPosyandu->id,
            'nama_kegiatan' => 'Kegiatan di luar wilayah',
        ]);

        $this->actingAs($puskesmasUser)
            ->get(route('puskesmas.monitoring.index'))
            ->assertOk()
            ->assertSee('Monitoring Perkembangan Peserta')
            ->assertSee('Perkembangan Terbaru');

        $this->assertSame(
            0,
            JadwalKegiatan::where('posyandu_id', $otherPosyandu->id)->count(),
        );
    }

    public function test_puskesmas_can_manage_activities_and_immunization(): void
    {
        $puskesmas = User::where('email', 'puskesmas@gmail.com')->firstOrFail();
        $posyanduId = Posyandu::where('nama_posyandu', 'Posyandu Demo')->value('id');
        $participant = Peserta::where('nama', 'Sinta')->firstOrFail();

        $this->actingAs($puskesmas)
            ->post(route('puskesmas.kegiatan.store'), [
                'posyandu_id' => $posyanduId,
                'nama_kegiatan' => 'Kelas Gizi Balita',
                'jenis_kegiatan' => 'Penyuluhan',
                'tanggal_kegiatan' => '2026-12-01',
                'waktu_mulai' => '09:00',
                'lokasi' => 'Posyandu Demo',
                'status' => 'terjadwal',
            ])
            ->assertRedirect(route('puskesmas.kegiatan.index'));

        $this->assertDatabaseHas('kegiatan', [
            'posyandu_id' => $posyanduId,
            'nama_kegiatan' => 'Kelas Gizi Balita',
        ]);

        $this->actingAs($puskesmas)
            ->post(route('puskesmas.imunisasi.store'), [
                'peserta_id' => $participant->id,
                'jenis_imunisasi' => 'DPT',
                'tanggal_jadwal' => '2026-12-02',
                'status' => 'terjadwal',
            ])
            ->assertRedirect(route('puskesmas.imunisasi.index'));

        $this->assertDatabaseHas('imunisasi', [
            'peserta_id' => $participant->id,
            'jenis_imunisasi' => 'DPT',
            'status' => 'terjadwal',
        ]);

    }

    public function test_puskesmas_schedule_drives_kader_attendance_examination_and_meeting_report(): void
    {
        Carbon::setTestNow('2026-11-08 09:00:00');

        $puskesmas = User::where('email', 'puskesmas@gmail.com')->firstOrFail();
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $participant = Peserta::where('nama', 'Sinta')->firstOrFail();
        $posyanduId = Posyandu::where('nama_posyandu', 'Posyandu Demo')->value('id');

        $this->actingAs($puskesmas)
            ->post(route('puskesmas.kegiatan.store'), [
                'posyandu_id' => $posyanduId,
                'nama_kegiatan' => 'Pertemuan 1',
                'jenis_kegiatan' => 'Posyandu Rutin',
                'tanggal_kegiatan' => '2026-11-08',
                'waktu_mulai' => '09:00',
                'lokasi' => 'Posyandu Demo',
                'status' => 'terjadwal',
            ])
            ->assertRedirect(route('puskesmas.kegiatan.index'));

        $kegiatan = JadwalKegiatan::where('nama_kegiatan', 'Pertemuan 1')->firstOrFail();

        $this->actingAs($kader)
            ->get(route('kader.jadwal.show', $kegiatan))
            ->assertOk()
            ->assertSee('Pertemuan hari ini siap dimulai');

        $this->actingAs($kader)
            ->post(route('kader.jadwal.start', $kegiatan))
            ->assertRedirect(route('kader.jadwal.show', $kegiatan));

        $this->actingAs($kader)
            ->get(route('kader.jadwal.show', $kegiatan))
            ->assertOk()
            ->assertSee($participant->nama)
            ->assertSee('Absensi peserta')
            ->assertSee('Catatan untuk laporan Puskesmas');

        $this->actingAs($kader)
            ->get(route('kader.pemeriksaan.create', ['kegiatan_id' => $kegiatan->id, 'peserta_id' => $participant->id]))
            ->assertForbidden();

        $this->actingAs($kader)
            ->put(route('kader.jadwal.attendance', $kegiatan), [
                'kehadiran' => [
                    $participant->id => 'hadir',
                ],
            ])
            ->assertRedirect(route('kader.jadwal.show', $kegiatan));

        $this->actingAs($kader)
            ->post(route('kader.jadwal.check-in', $kegiatan))
            ->assertRedirect(route('kader.jadwal.show', $kegiatan));

        $this->actingAs($kader)
            ->get(route('kader.pemeriksaan.create', ['kegiatan_id' => $kegiatan->id, 'peserta_id' => $participant->id]))
            ->assertOk()
            ->assertSee('Pertemuan 1');

        $this->actingAs($kader)
            ->post(route('kader.pemeriksaan.store'), [
                'peserta_id' => $participant->id,
                'kegiatan_id' => $kegiatan->id,
                'tanggal_pemeriksaan' => '2026-11-08',
                'berat_badan' => 12.5,
            ])
            ->assertRedirect(route('kader.pemeriksaan.index'));

        $this->assertDatabaseHas('pemeriksaan', [
            'peserta_id' => $participant->id,
            'kegiatan_id' => $kegiatan->id,
        ]);
        $this->assertDatabaseHas('peserta_kegiatan', [
            'kegiatan_id' => $kegiatan->id,
            'peserta_id' => $participant->id,
            'status_kehadiran' => 'hadir',
        ]);
        $this->assertDatabaseHas('kegiatan_petugas', [
            'kegiatan_id' => $kegiatan->id,
            'user_id' => $kader->id,
            'status_kehadiran' => 'hadir',
        ]);

        $this->actingAs($kader)
            ->get(route('kader.jadwal.show', $kegiatan))
            ->assertOk()
            ->assertViewHas('jadwal', fn (JadwalKegiatan $jadwal): bool => $jadwal->peserta_hadir_count === 1
                && $jadwal->petugas_hadir_count === 1);

        $this->actingAs($kader)
            ->post(route('kader.jadwal.finish', $kegiatan), [
                'catatan_laporan' => 'Kegiatan berjalan lancar.',
            ])
            ->assertRedirect(route('kader.jadwal.show', $kegiatan));

        $report = $this->actingAs($puskesmas)
            ->get(route('puskesmas.kegiatan.show', $kegiatan))
            ->assertOk()
            ->assertSee('Laporan Pertemuan 1')
            ->assertSee('Peserta hadir')
            ->assertSee('Pemeriksaan dilakukan')
            ->assertSee('Petugas yang hadir')
            ->assertSee('Sinta')
            ->assertSee('Kader Posyandu')
            ->assertSee('Kegiatan berjalan lancar.');

        $this->assertDatabaseHas('kegiatan', [
            'id' => $kegiatan->id,
            'catatan_laporan' => 'Kegiatan berjalan lancar.',
            'status' => 'selesai',
        ]);

        $laporan = $report->viewData('kegiatan');
        $this->assertSame(1, (int) $laporan->peserta_hadir_count);
        $this->assertSame(1, (int) $laporan->pemeriksaans_count);
        $this->assertSame(1, (int) $laporan->petugas_hadir_count);
    }

    public function test_examination_from_kader_menu_is_attached_to_the_only_active_meeting_today(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $participant = Peserta::where('nama', 'Sinta')->firstOrFail();
        $posyanduId = Posyandu::where('nama_posyandu', 'Posyandu Demo')->value('id');
        $meeting = JadwalKegiatan::create([
            'posyandu_id' => $posyanduId,
            'nama_kegiatan' => 'Pertemuan pemeriksaan langsung',
            'jenis_kegiatan' => 'Posyandu Rutin',
            'tanggal_kegiatan' => today()->toDateString(),
            'waktu_mulai' => '09:00',
            'status' => 'berlangsung',
        ]);

        $this->actingAs($kader)
            ->post(route('kader.pemeriksaan.store'), [
                'peserta_id' => $participant->id,
                'tanggal_pemeriksaan' => today()->toDateString(),
                'berat_badan' => 12.5,
            ])
            ->assertRedirect(route('kader.pemeriksaan.index'));

        $this->assertDatabaseHas('pemeriksaan', [
            'peserta_id' => $participant->id,
            'kegiatan_id' => $meeting->id,
        ]);
        $this->assertDatabaseHas('peserta_kegiatan', [
            'kegiatan_id' => $meeting->id,
            'peserta_id' => $participant->id,
            'status_kehadiran' => 'hadir',
        ]);

        $this->actingAs($kader)
            ->get(route('kader.jadwal.show', $meeting))
            ->assertOk()
            ->assertSee($participant->nama)
            ->assertViewHas('jadwal', fn (JadwalKegiatan $jadwal): bool => $jadwal->peserta_hadir_count === 1
                && $jadwal->pemeriksaans_count === 1);
    }

    public function test_examination_from_kader_menu_is_not_attached_when_multiple_active_meetings_match_today(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $participant = Peserta::where('nama', 'Sinta')->firstOrFail();
        $posyanduId = Posyandu::where('nama_posyandu', 'Posyandu Demo')->value('id');

        $meetings = collect(['Pertemuan pertama hari ini', 'Pertemuan kedua hari ini'])
            ->map(fn (string $name): JadwalKegiatan => JadwalKegiatan::create([
                'posyandu_id' => $posyanduId,
                'nama_kegiatan' => $name,
                'jenis_kegiatan' => 'Posyandu Rutin',
                'tanggal_kegiatan' => today()->toDateString(),
                'waktu_mulai' => '09:00',
                'status' => 'berlangsung',
            ]));

        $this->actingAs($kader)
            ->post(route('kader.pemeriksaan.store'), [
                'peserta_id' => $participant->id,
                'tanggal_pemeriksaan' => today()->toDateString(),
                'berat_badan' => 12.5,
            ])
            ->assertRedirect(route('kader.pemeriksaan.index'));

        $this->assertDatabaseHas('pemeriksaan', [
            'peserta_id' => $participant->id,
            'kegiatan_id' => null,
        ]);
        foreach ($meetings as $meeting) {
            $this->assertDatabaseMissing('peserta_kegiatan', [
                'kegiatan_id' => $meeting->id,
                'peserta_id' => $participant->id,
            ]);
        }
    }

    public function test_unlinked_examinations_are_backfilled_only_for_one_matching_meeting(): void
    {
        $participant = Peserta::where('nama', 'Sinta')->firstOrFail();
        $posyanduId = Posyandu::where('nama_posyandu', 'Posyandu Demo')->value('id');
        $meetingDate = today()->subDay()->toDateString();
        $meeting = JadwalKegiatan::create([
            'posyandu_id' => $posyanduId,
            'nama_kegiatan' => 'Pertemuan pemeriksaan tunggal',
            'jenis_kegiatan' => 'Posyandu Rutin',
            'tanggal_kegiatan' => $meetingDate,
            'waktu_mulai' => '09:00',
            'status' => 'selesai',
        ]);
        $ambiguousMeetingDate = today()->subDays(2)->toDateString();
        $firstAmbiguousMeeting = JadwalKegiatan::create([
            'posyandu_id' => $posyanduId,
            'nama_kegiatan' => 'Pertemuan ganda pertama',
            'jenis_kegiatan' => 'Posyandu Rutin',
            'tanggal_kegiatan' => $ambiguousMeetingDate,
            'waktu_mulai' => '09:00',
            'status' => 'selesai',
        ]);
        JadwalKegiatan::create([
            'posyandu_id' => $posyanduId,
            'nama_kegiatan' => 'Pertemuan ganda kedua',
            'jenis_kegiatan' => 'Posyandu Rutin',
            'tanggal_kegiatan' => $ambiguousMeetingDate,
            'waktu_mulai' => '10:00',
            'status' => 'selesai',
        ]);
        $unlinkedExamination = Pemeriksaan::create([
            'peserta_id' => $participant->id,
            'tanggal_pemeriksaan' => $meetingDate,
        ]);
        $ambiguousExamination = Pemeriksaan::create([
            'peserta_id' => $participant->id,
            'tanggal_pemeriksaan' => $ambiguousMeetingDate,
        ]);

        $migration = require database_path('migrations/2026_11_26_151836_link_unassigned_examinations_to_unique_meetings.php');
        $migration->up();

        $this->assertDatabaseHas('pemeriksaan', [
            'id' => $unlinkedExamination->id,
            'kegiatan_id' => $meeting->id,
        ]);
        $this->assertDatabaseHas('peserta_kegiatan', [
            'kegiatan_id' => $meeting->id,
            'peserta_id' => $participant->id,
            'status_kehadiran' => 'hadir',
        ]);
        $this->assertDatabaseHas('pemeriksaan', [
            'id' => $ambiguousExamination->id,
            'kegiatan_id' => null,
        ]);
        $this->assertDatabaseMissing('peserta_kegiatan', [
            'kegiatan_id' => $firstAmbiguousMeeting->id,
            'peserta_id' => $participant->id,
        ]);
    }
}
