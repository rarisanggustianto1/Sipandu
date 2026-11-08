<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AllRolesAccessTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    public function test_dinas_kesehatan_can_access_all_dinas_pages(): void
    {
        $dinasUser = User::where('email', 'dinas@gmail.com')->firstOrFail();

        $routes = [
            route('dinas.dashboard'),
            route('dinas.puskesmas.index'),
            route('dinas.puskesmas.create'),
            route('dinas.edukasi.index'),
            route('dinas.edukasi.create'),
            route('dinas.laporan.index'),
        ];

        foreach ($routes as $url) {
            $response = $this->actingAs($dinasUser)->get($url);
            $response->assertOk()
                ->assertSee('images/sipandu-logo.png')
                ->assertSee('class="dinas-sidebar"', false)
                ->assertDontSee('📊')
                ->assertDontSee('🏥')
                ->assertDontSee('📖');
        }
    }

    public function test_puskesmas_can_access_all_puskesmas_pages(): void
    {
        $puskesmasUser = User::where('email', 'puskesmas@gmail.com')->firstOrFail();

        $routes = [
            route('puskesmas.dashboard'),
            route('puskesmas.posyandu.index'),
            route('puskesmas.posyandu.create'),
            route('puskesmas.peserta.index'),
            route('puskesmas.monitoring.index'),
            route('puskesmas.kegiatan.index'),
            route('puskesmas.kegiatan.create'),
            route('puskesmas.kegiatan.show', 1),
            route('puskesmas.imunisasi.index'),
            route('puskesmas.imunisasi.create'),
            route('puskesmas.tindak-lanjut.index'),
            route('puskesmas.kader.index'),
            route('puskesmas.kader.create'),
            route('puskesmas.pengaduan.index'),
        ];

        foreach ($routes as $url) {
            $response = $this->actingAs($puskesmasUser)->get($url);
            $response->assertOk()
                ->assertSee('images/sipandu-logo.png')
                ->assertSee('id="sidebar"', false)
                ->assertSee('Navigasi utama SIPANDU')
                ->assertSee('Data Peserta & KIA')
                ->assertSee('Kelola Kegiatan')
                ->assertSee('Kelola Imunisasi')
                ->assertSee('Tindak Lanjut Peserta')
                ->assertSee('Monitoring Perkembangan')
                ->assertDontSee('📊')
                ->assertDontSee('🏥')
                ->assertDontSee('💉');
        }
    }

    public function test_kader_can_access_all_kader_pages(): void
    {
        $kaderUser = User::where('email', 'kader@gmail.com')->firstOrFail();

        $routes = [
            route('kader.pemeriksaan.index'),
            route('kader.pemeriksaan.create'),
            route('kader.dashboard'),
            route('kader.peserta.index'),
            route('kader.monitoring.index'),
            route('kader.jadwal.index'),
            route('kader.jadwal.show', 1),
            route('kader.imunisasi.index'),
            route('kader.imunisasi.create'),
        ];

        foreach ($routes as $url) {
            $response = $this->actingAs($kaderUser)->get($url);
            $response->assertOk()
                ->assertSee('images/sipandu-logo.png')
                ->assertSee('id="sidebar"', false)
                ->assertSee('Navigasi utama SIPANDU')
                ->assertDontSee('📊')
                ->assertDontSee('🩺')
                ->assertDontSee('👥');
        }
    }

    public function test_keluarga_can_access_all_peserta_pages(): void
    {
        $pesertaUser = User::where('email', 'peserta@gmail.com')->firstOrFail();

        $routes = [
            route('peserta.dashboard'),
            route('peserta.data.index'),
            route('peserta.keluarga.index'),
            route('peserta.edukasi.index'),
        ];

        foreach ($routes as $url) {
            $response = $this->actingAs($pesertaUser)->get($url);
            $response->assertOk()
                ->assertSee('images/sipandu-logo.png')
                ->assertSee('id="sidebar"', false)
                ->assertSee('Navigasi utama SIPANDU')
                ->assertDontSee('🏠')
                ->assertDontSee('📋')
                ->assertDontSee('👨‍👩‍👧');
        }
    }
}
