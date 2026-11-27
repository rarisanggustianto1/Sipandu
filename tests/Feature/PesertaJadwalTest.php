<?php

namespace Tests\Feature;

use App\Models\Kader\JadwalKegiatan;
use App\Models\Puskesmas\Posyandu;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class PesertaJadwalTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->travelTo(Carbon::parse('2026-11-26 09:00:00'));
        $this->seed(DatabaseSeeder::class);
    }

    public function test_family_sees_puskesmas_schedules_for_its_posyandu_only(): void
    {
        $puskesmas = User::where('email', 'puskesmas@gmail.com')->firstOrFail();
        $family = User::where('email', 'peserta@gmail.com')->firstOrFail();
        $posyandu = Posyandu::where('nama_posyandu', 'Posyandu Demo')->firstOrFail();
        $otherPosyandu = Posyandu::create([
            'puskesmas_id' => $puskesmas->puskesmas_id,
            'nama_posyandu' => 'Posyandu Lain',
            'alamat' => 'Alamat Posyandu Lain',
            'kelurahan' => 'Kelurahan Lain',
            'kecamatan' => 'Kecamatan Demo',
        ]);

        JadwalKegiatan::create([
            'posyandu_id' => $posyandu->id,
            'nama_kegiatan' => 'Jadwal Dibatalkan',
            'jenis_kegiatan' => 'Pemeriksaan',
            'tanggal_kegiatan' => '2026-11-27',
            'status' => 'dibatalkan',
        ]);
        JadwalKegiatan::create([
            'posyandu_id' => $otherPosyandu->id,
            'nama_kegiatan' => 'Jadwal Posyandu Lain',
            'jenis_kegiatan' => 'Pemeriksaan',
            'tanggal_kegiatan' => '2026-11-27',
            'status' => 'terjadwal',
        ]);

        $this->actingAs($puskesmas)
            ->post(route('puskesmas.kegiatan.store'), [
                'posyandu_id' => $posyandu->id,
                'nama_kegiatan' => 'Pemeriksaan Terpadu Keluarga',
                'jenis_kegiatan' => 'Pemeriksaan',
                'tanggal_kegiatan' => '2026-11-29',
                'waktu_mulai' => '08:30',
                'lokasi' => 'Balai Posyandu Demo',
                'status' => 'terjadwal',
            ])
            ->assertRedirect(route('puskesmas.kegiatan.index'));

        $this->assertDatabaseHas('kegiatan', [
            'posyandu_id' => $posyandu->id,
            'nama_kegiatan' => 'Pemeriksaan Terpadu Keluarga',
        ]);

        $this->actingAs($family)
            ->get(route('peserta.jadwal.index'))
            ->assertOk()
            ->assertSee('Pemeriksaan Terpadu Keluarga')
            ->assertSee('Posyandu Demo')
            ->assertSee('Balai Posyandu Demo')
            ->assertSee('08:30')
            ->assertSee('href="'.route('peserta.jadwal.index').'"', false)
            ->assertDontSee('Jadwal Dibatalkan')
            ->assertDontSee('Jadwal Posyandu Lain');

        $this->get(route('peserta.dashboard'))
            ->assertOk()
            ->assertSee('Pemeriksaan Terpadu Keluarga')
            ->assertSee(route('peserta.jadwal.index'), escape: false);
    }

    public function test_guest_is_redirected_to_login_from_family_schedule_list(): void
    {
        $this->get(route('peserta.jadwal.index'))
            ->assertRedirect(route('login'));
    }

    public function test_non_family_role_cannot_open_family_schedule_list(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();

        $this->actingAs($kader)
            ->get(route('peserta.jadwal.index'))
            ->assertForbidden();
    }

    public function test_family_dashboard_ignores_cancelled_upcoming_schedules(): void
    {
        $family = User::where('email', 'peserta@gmail.com')->firstOrFail();
        $posyandu = Posyandu::where('nama_posyandu', 'Posyandu Demo')->firstOrFail();

        JadwalKegiatan::create([
            'posyandu_id' => $posyandu->id,
            'nama_kegiatan' => 'Jadwal Dibatalkan Terdekat',
            'jenis_kegiatan' => 'Pemeriksaan',
            'tanggal_kegiatan' => '2026-11-27',
            'status' => 'dibatalkan',
        ]);

        $this->actingAs($family)
            ->get(route('peserta.dashboard'))
            ->assertOk()
            ->assertSee('Pelayanan Posyandu Rutin')
            ->assertDontSee('Jadwal Dibatalkan Terdekat');
    }
}
