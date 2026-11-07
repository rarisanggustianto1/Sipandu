<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PuskesmasSidebarFolderTest extends TestCase
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
            'email' => 'folder.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'tenaga_kesehatan',
            'puskesmas_id' => $puskesmasId,
        ]);
    }

    public function test_setiap_kelompok_dijadikan_folder(): void
    {
        $html = $this->actingAs($this->makeUser())
            ->get(route('puskesmas.dashboard'))
            ->assertOk()
            ->getContent();

        foreach ([
            'master-data',
            'pelayanan-agenda',
            'intervensi-rujukan',
            'rekap-analitik',
        ] as $key) {
            $this->assertStringContainsString('data-nav-group="' . $key . '"', $html, "Folder {$key} tidak ada");
        }

        // Tiap folder harus punya <summary> (kepala yang diklik)
        $this->assertSame(4, substr_count($html, '<summary'), 'Jumlah <summary> harus 4');
        $this->assertSame(4, substr_count($html, '</details>'), 'Jumlah </details> harus 4');
    }

    public function test_folder_dalam_tutup_bila_tidak_ada_halaman_aktif(): void
    {
        $html = $this->actingAs($this->makeUser())
            ->get(route('puskesmas.dashboard'))
            ->getContent();

        // Di halaman dashboard, folder Master Data tidak boleh punya atribut open
        $this->assertMatchesRegularExpression(
            '/data-nav-group="master-data"[^>]*>/',
            $html
        );
        $this->assertDoesNotMatchRegularExpression(
            '/data-nav-group="master-data"[^>]*\sopen/',
            $html
        );
    }

    public function test_folder_otomatis_terbuka_saat_halaman_aktif_di_dalamnya(): void
    {
        $user = $this->makeUser();

        // Halaman Posyandu berada di dalam folder "Master Data"
        $html = $this->actingAs($user)
            ->get(route('puskesmas.posyandu.index'))
            ->assertOk()
            ->getContent();

        $this->assertMatchesRegularExpression(
            '/data-nav-group="master-data"[^>]*\sopen/',
            $html,
            'Folder Master Data harus otomatis terbuka di halaman Posyandu'
        );
    }

    public function test_isi_folder_master_data_mengandung_tiga_menu(): void
    {
        $user = $this->makeUser();

        $html = $this->actingAs($user)
            ->get(route('puskesmas.posyandu.index'))
            ->getContent();

        // Ambil isi folder Master Data saja
        preg_match('/data-nav-group="master-data".*?<\/details>/s', $html, $m);
        $this->assertNotEmpty($m, 'Folder Master Data tidak ditemukan');

        foreach (['Data Posyandu', 'Data Keluarga &amp; Peserta', 'Kelola Akun Kader'] as $label) {
            $this->assertStringContainsString($label, $m[0], "Menu {$label} tidak ada di dalam folder");
        }
    }
}