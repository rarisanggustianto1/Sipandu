<?php

namespace Tests\Feature;

use App\Models\Kader\Imunisasi;
use App\Models\Kader\JadwalKegiatan;
use App\Models\Kader\Pemeriksaan;
use App\Models\Peserta\Keluarga;
use App\Models\Peserta\Peserta;
use App\Models\Puskesmas\Posyandu;
use App\Models\Puskesmas\Puskesmas;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class HealthRecordSynchronizationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_kader_examination_is_saved_and_monitoring_uses_the_selected_participant_history(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $sinta = Peserta::where('nama', 'Sinta')->firstOrFail();

        $this->actingAs($kader)
            ->get(route('kader.pemeriksaan.create', ['peserta_id' => $sinta->id]))
            ->assertOk()
            ->assertSee('Sinta')
            ->assertSee('action="'.route('kader.pemeriksaan.store').'"', false)
            ->assertSee('Pertumbuhan bayi / balita')
            ->assertSee('Pemeriksaan ibu hamil')
            ->assertSee('Pemeriksaan lansia')
            ->assertSee('data-kategori="balita"', false);

        $response = $this->actingAs($kader)->post(route('kader.pemeriksaan.store'), [
            'peserta_id' => $sinta->id,
            'tanggal_pemeriksaan' => '2026-11-08',
            'berat_badan' => 13.4,
            'tinggi_badan' => 91,
            'lingkar_kepala' => 49,
            'perkembangan' => 'Sesuai usia',
            'status_gizi' => 'Normal',
            'catatan' => 'Pemeriksaan terbaru Sinta',
        ]);

        $response->assertRedirect(route('kader.pemeriksaan.index'));

        $pemeriksaan = Pemeriksaan::where('peserta_id', $sinta->id)
            ->whereDate('tanggal_pemeriksaan', '2026-11-08')
            ->firstOrFail();

        $this->assertDatabaseHas('pemeriksaan_balita', [
            'pemeriksaan_id' => $pemeriksaan->id,
            'berat_badan' => 13.4,
            'tinggi_badan' => 91,
            'lingkar_kepala' => 49,
        ]);

        $this->actingAs($kader)
            ->get(route('kader.peserta.index'))
            ->assertOk()
            ->assertSee('Kartu kesehatan')
            ->assertSee(route('kader.peserta.show', $sinta), escape: false);

        $this->actingAs($kader)
            ->get(route('kader.peserta.show', $sinta->id))
            ->assertOk()
            ->assertSee('Kartu Kesehatan')
            ->assertSee('Grafik pertumbuhan & kesehatan', escape: false)
            ->assertSee('polyline points="', escape: false)
            ->assertSee('Riwayat pemeriksaan')
            ->assertSee('Catat pemeriksaan')
            ->assertSee('images/sipandu-logo.png')
            ->assertSee('Pemeriksaan terbaru Sinta')
            ->assertSee('13.4');

        $familyUser = User::where('email', 'peserta@gmail.com')->firstOrFail();

        $this->actingAs($familyUser)
            ->get(route('peserta.data.show', $sinta))
            ->assertOk()
            ->assertSee('Kartu Kesehatan')
            ->assertSee('Grafik pertumbuhan & kesehatan', escape: false)
            ->assertSee('polyline points="', escape: false)
            ->assertSee('Riwayat pemeriksaan')
            ->assertSee('13.4')
            ->assertSee('images/sipandu-logo.png');
    }

    public function test_kader_examination_page_lists_participants_by_category_and_links_to_the_record_form(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $sinta = Peserta::where('nama', 'Sinta')->firstOrFail();
        $bumil = Peserta::where('kategori', 'ibu_hamil')->firstOrFail();
        $lansia = Peserta::where('kategori', 'lansia')->firstOrFail();

        $this->actingAs($kader)
            ->get(route('kader.pemeriksaan.index'))
            ->assertOk()
            ->assertSee('Siapa yang ingin diperiksa?')
            ->assertSee('Cari nama peserta...')
            ->assertSee('Semua')
            ->assertSee('Bayi & Balita (1)')
            ->assertSee('Ibu Hamil (1)')
            ->assertSee('Lansia (1)')
            ->assertSee($sinta->nama)
            ->assertSee($bumil->nama)
            ->assertSee($lansia->nama)
            ->assertSee(route('kader.pemeriksaan.create', ['peserta_id' => $sinta->id]), escape: false)
            ->assertSee(route('kader.pemeriksaan.create', ['peserta_id' => $bumil->id]), escape: false)
            ->assertSee(route('kader.pemeriksaan.create', ['peserta_id' => $lansia->id]), escape: false)
            ->assertDontSee('Riwayat Pemeriksaan')
            ->assertDontSee('Pemeriksaan terbaru Sinta');
    }

    public function test_kader_can_filter_examination_participants_by_category_and_name(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $balita = Peserta::where('nama', 'Sinta')->firstOrFail();

        $this->actingAs($kader)
            ->get(route('kader.pemeriksaan.index', [
                'kategori' => 'balita',
                'search' => 'Sin',
            ]))
            ->assertOk()
            ->assertSee($balita->nama)
            ->assertDontSee('Siti Aminah')
            ->assertDontSee('Budi Santoso')
            ->assertSee(route('kader.pemeriksaan.create', ['peserta_id' => $balita->id]), escape: false);

        $this->actingAs($kader)
            ->get(route('kader.pemeriksaan.index', ['kategori' => 'tidak-valid']))
            ->assertSessionHasErrors('kategori');
    }

    public function test_kader_lists_only_participants_assigned_to_their_posyandu(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $otherParticipant = $this->createParticipantForAnotherPosyandu('Peserta Rahasia');
        $otherExamination = Pemeriksaan::create([
            'peserta_id' => $otherParticipant->id,
            'tanggal_pemeriksaan' => '2026-11-07',
            'catatan' => 'Pemeriksaan posyandu lain',
        ]);
        $otherImmunization = Imunisasi::create([
            'peserta_id' => $otherParticipant->id,
            'jenis_imunisasi' => 'Imunisasi Rahasia',
            'status' => 'selesai',
        ]);
        $otherSchedule = JadwalKegiatan::create([
            'posyandu_id' => $otherParticipant->keluarga->posyandu_id,
            'nama_kegiatan' => 'Jadwal Posyandu Rahasia',
            'jenis_kegiatan' => 'Pemeriksaan',
            'tanggal_kegiatan' => '2026-11-09',
            'lokasi' => 'Lokasi Rahasia',
            'status' => 'terjadwal',
        ]);

        $this->actingAs($kader)
            ->get(route('kader.peserta.index'))
            ->assertOk()
            ->assertDontSee('Peserta Rahasia');

        $this->actingAs($kader)
            ->get(route('kader.pemeriksaan.index'))
            ->assertOk()
            ->assertDontSee('Peserta Rahasia')
            ->assertDontSee('Pemeriksaan posyandu lain');

        $this->actingAs($kader)
            ->get(route('kader.monitoring.index'))
            ->assertOk()
            ->assertDontSee('Peserta Rahasia');

        $this->actingAs($kader)
            ->get(route('kader.monitoring.show', 'balita'))
            ->assertOk()
            ->assertDontSee('Peserta Rahasia');

        $this->actingAs($kader)
            ->get(route('kader.peserta.show', $otherParticipant->id))
            ->assertNotFound();

        $this->actingAs($kader)
            ->get(route('kader.imunisasi.index'))
            ->assertOk()
            ->assertDontSee('Imunisasi Rahasia');

        $this->actingAs($kader)
            ->get(route('kader.imunisasi.show', $otherImmunization))
            ->assertNotFound();

        $this->actingAs($kader)
            ->get(route('kader.jadwal.index'))
            ->assertOk()
            ->assertDontSee('Jadwal Posyandu Rahasia');

        $this->actingAs($kader)
            ->get(route('kader.jadwal.show', $otherSchedule))
            ->assertNotFound();

        $this->actingAs($kader)
            ->post(route('kader.pemeriksaan.store'), [
                'peserta_id' => $otherParticipant->id,
                'tanggal_pemeriksaan' => '2026-11-08',
                'berat_badan' => 12,
            ])
            ->assertNotFound();

        $this->actingAs($kader)
            ->post(route('kader.imunisasi.store'), [
                'peserta_id' => $otherParticipant->id,
                'jenis_imunisasi' => 'Imunisasi Tidak Sah',
            ])
            ->assertNotFound();

        $this->actingAs($kader)
            ->post('/kader/jadwal', [
                'posyandu_id' => $otherParticipant->keluarga->posyandu_id,
                'nama_kegiatan' => 'Jadwal Posyandu Saya',
                'tanggal_kegiatan' => '2026-11-10',
                'lokasi' => 'Posyandu Saya',
            ])
            ->assertMethodNotAllowed();

        $this->assertDatabaseMissing('kegiatan', [
            'nama_kegiatan' => 'Jadwal Posyandu Saya',
        ]);
    }

    public function test_monitoring_shows_only_the_selected_participants_category_and_latest_values(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $bumil = Peserta::where('kategori', 'ibu_hamil')->firstOrFail();

        $this->actingAs($kader)
            ->post(route('kader.pemeriksaan.store'), [
                'peserta_id' => $bumil->id,
                'tanggal_pemeriksaan' => '2026-11-08',
                'berat_badan' => 61.2,
                'usia_kehamilan' => 28,
                'tekanan_darah' => '120/80',
                'tinggi_fundus' => 27,
                'denyut_jantung_janin' => 140,
                'catatan_kehamilan' => 'Kondisi ibu dan janin baik',
            ])
            ->assertRedirect(route('kader.pemeriksaan.index'));

        $pemeriksaan = Pemeriksaan::where('peserta_id', $bumil->id)
            ->whereDate('tanggal_pemeriksaan', '2026-11-08')
            ->firstOrFail();

        $this->assertDatabaseHas('pemeriksaan_bumil', [
            'pemeriksaan_id' => $pemeriksaan->id,
            'usia_kehamilan' => 28,
            'berat_badan' => 61.2,
        ]);

        $this->actingAs($kader)
            ->get(route('kader.peserta.show', $bumil->id))
            ->assertOk()
            ->assertSee('Kondisi ibu dan janin baik')
            ->assertSee('28 minggu')
            ->assertDontSee('Gizi Baik');
    }

    public function test_lansia_examination_saves_only_lansia_measurements(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $lansia = Peserta::where('kategori', 'lansia')->firstOrFail();

        $this->actingAs($kader)
            ->post(route('kader.pemeriksaan.store'), [
                'peserta_id' => $lansia->id,
                'tanggal_pemeriksaan' => '2026-11-08',
                'berat_badan' => 68.5,
                'tekanan_darah' => '130/80',
                'gula_darah' => 110,
                'kolesterol' => 180,
                'asam_urat' => 6.2,
                'catatan_kesehatan' => 'Kontrol tekanan darah bulan depan',
                'tinggi_badan' => -1,
            ])
            ->assertRedirect(route('kader.pemeriksaan.index'));

        $pemeriksaan = Pemeriksaan::where('peserta_id', $lansia->id)
            ->whereDate('tanggal_pemeriksaan', '2026-11-08')
            ->firstOrFail();

        $this->assertDatabaseHas('pemeriksaan_lansia', [
            'pemeriksaan_id' => $pemeriksaan->id,
            'berat_badan' => 68.5,
            'tekanan_darah' => '130/80',
            'gula_darah' => 110,
            'kolesterol' => 180,
            'asam_urat' => 6.2,
            'catatan_kesehatan' => 'Kontrol tekanan darah bulan depan',
        ]);

        $this->assertDatabaseMissing('pemeriksaan_balita', [
            'pemeriksaan_id' => $pemeriksaan->id,
        ]);
    }

    public function test_examination_requires_weight_for_selected_category(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();
        $balita = Peserta::where('kategori', 'balita')->firstOrFail();

        $this->actingAs($kader)
            ->from(route('kader.pemeriksaan.create', ['peserta_id' => $balita->id]))
            ->post(route('kader.pemeriksaan.store'), [
                'peserta_id' => $balita->id,
                'tanggal_pemeriksaan' => '2026-11-08',
            ])
            ->assertSessionHasErrors('berat_badan');

        $this->assertDatabaseMissing('pemeriksaan', [
            'peserta_id' => $balita->id,
            'tanggal_pemeriksaan' => '2026-11-08',
        ]);
    }

    public function test_family_can_log_in_with_household_number_and_add_only_its_own_members(): void
    {
        $familyUser = User::where('email', 'peserta@gmail.com')->firstOrFail();
        $family = $familyUser->keluarga;
        $otherParticipant = $this->createParticipantForAnotherPosyandu('Anggota Keluarga Lain');

        $this->post(route('login'), [
            'login' => $family->no_kk,
            'password' => 'password123',
        ])->assertRedirect(route('home'));

        $this->post(route('peserta.data.store'), [
            'keluarga_id' => $otherParticipant->keluarga_id,
            'nik' => '1871010101240099',
            'nama' => 'Anggota Baru',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '2024-01-01',
            'kategori' => 'balita',
        ])->assertRedirect(route('peserta.data.show', Peserta::where('nik', '1871010101240099')->firstOrFail()));

        $this->assertDatabaseHas('peserta', [
            'nik' => '1871010101240099',
            'keluarga_id' => $family->id,
        ]);

        $this->get(route('peserta.data.index'))
            ->assertOk()
            ->assertSee('Anggota Baru')
            ->assertDontSee('Anggota Keluarga Lain');

        $this->get(route('peserta.keluarga.index'))
            ->assertOk()
            ->assertSee($family->nama_kepala_keluarga)
            ->assertDontSee('Keluarga Lain');

        $this->get(route('peserta.data.show', $otherParticipant->id))
            ->assertNotFound();
    }

    public function test_kader_registration_creates_family_account_and_first_participant(): void
    {
        $kader = User::where('email', 'kader@gmail.com')->firstOrFail();

        $this->actingAs($kader)
            ->post(route('kader.peserta.store'), [
                'no_kk' => '1871000000000099',
                'nama_kepala_keluarga' => 'Keluarga Baru',
                'alamat' => 'Alamat Keluarga Baru',
                'no_telepon' => '08123456789',
                'password' => 'password-baru',
                'password_confirmation' => 'password-baru',
                'nik' => '1871010101240098',
                'nama' => 'Bayi Baru',
                'jenis_kelamin' => 'L',
                'tanggal_lahir' => '2024-01-01',
                'kategori' => 'balita',
            ])
            ->assertRedirect(route('kader.peserta.index'));

        $family = Keluarga::where('no_kk', '1871000000000099')->firstOrFail();

        $this->assertDatabaseHas('users', [
            'keluarga_id' => $family->id,
            'email' => null,
            'role' => 'keluarga',
        ]);

        $this->assertDatabaseHas('peserta', [
            'keluarga_id' => $family->id,
            'nik' => '1871010101240098',
            'nama' => 'Bayi Baru',
        ]);

        $this->post(route('logout'));

        $this->post(route('login'), [
            'login' => $family->no_kk,
            'password' => 'password-baru',
        ])->assertRedirect(route('home'));

        $this->put(route('profile'), [
            'name' => $family->nama_kepala_keluarga,
            'password' => 'password-diganti',
            'password_confirmation' => 'password-diganti',
        ])->assertRedirect(route('profile'));

        $this->post(route('logout'));

        $this->post(route('login'), [
            'login' => $family->no_kk,
            'password' => 'password-diganti',
        ])->assertRedirect(route('home'));
    }

    private function createParticipantForAnotherPosyandu(string $name): Peserta
    {
        $puskesmas = Puskesmas::firstOrFail();
        $posyandu = Posyandu::create([
            'puskesmas_id' => $puskesmas->id,
            'nama_posyandu' => 'Posyandu Lain',
            'alamat' => 'Alamat Posyandu Lain',
            'kelurahan' => 'Kelurahan Lain',
            'kecamatan' => 'Kecamatan Lain',
        ]);

        $family = Keluarga::create([
            'posyandu_id' => $posyandu->id,
            'no_kk' => '1871000000000097',
            'nama_kepala_keluarga' => 'Keluarga Lain',
            'alamat' => 'Alamat Keluarga Lain',
        ]);

        return Peserta::create([
            'keluarga_id' => $family->id,
            'nik' => '1871010101240097',
            'nama' => $name,
            'jenis_kelamin' => 'L',
            'tanggal_lahir' => '2024-01-01',
            'kategori' => 'balita',
        ]);
    }
}
