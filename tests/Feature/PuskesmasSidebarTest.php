<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PuskesmasSidebarTest extends TestCase
{
    use RefreshDatabase;

    private function makeUser(): User
    {
        $dinasId = DB::table('dinas_kesehatan')->insertGetId([
            'nama_dinas' => 'Dinas Kesehatan Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $puskesmasId = DB::table('puskesmas')->insertGetId([
            'dinas_kesehatan_id' => $dinasId,
            'nama_puskesmas' => 'Puskesmas Test',
            'alamat' => 'Jl. Test',
            'kecamatan' => 'Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return User::create([
            'name' => 'Admin Puskesmas',
            'email' => 'sidebar.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'tenaga_kesehatan',
            'puskesmas_id' => $puskesmasId,
        ]);
    }

    public function test_sidebar_menampilkan_semua_kelompok_menu(): void
    {
        $response = $this->actingAs($this->makeUser())->get(route('puskesmas.dashboard'));

        $response->assertOk();

        foreach ([
            'Puskesmas Admin',
            'Master Data',
            'Pelayanan &amp; Agenda',
            'Intervensi &amp; Rujukan',
            'Rekap &amp; Analitik',
            'Data Posyandu',
            'Data Keluarga &amp; Peserta',
            'Kelola Akun Kader',
            'Kegiatan &amp; Sasaran',
            'Monitor Kegiatan',
            'Pengaduan &amp; Tanggapan',
            'Tindak Lanjut (Rujukan Kader)',
            'Riwayat Pemeriksaan',
            'Monitoring Perkembangan',
            'Segera',
        ] as $needle) {
            $response->assertSee($needle, escape: false);
        }
    }

    public function test_menu_aktif_menandai_halaman_sesuai(): void
    {
        $user = $this->makeUser();

        $this->actingAs($user)->get(route('puskesmas.dashboard'))
            ->assertSee('aria-current="page"', escape: false);

        $this->actingAs($user)->get(route('puskesmas.posyandu.index'))
            ->assertSee('aria-current="page"', escape: false);
    }

    public function test_menu_yang_belum_ada_tidak_menghasilkan_link(): void
    {
        $html = $this->actingAs($this->makeUser())
            ->get(route('puskesmas.dashboard'))
            ->getContent();

        $this->assertStringNotContainsString('>Kegiatan &amp; Sasaran</a>', $html);
        $this->assertStringContainsString('cursor-not-allowed', $html);
    }
}