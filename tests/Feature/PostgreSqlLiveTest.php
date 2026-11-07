<?php

namespace Tests\Feature;

use App\Http\Controllers\Puskesmas\PengaduanController;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

/**
 * Verifikasi aplikasi benar-benar berjalan di PostgreSQL.
 *
 * Jalankan dengan:
 *   set DB_CONNECTION=pgsql, DB_DATABASE=sipandu_test, ...
 *   php artisan test --filter=PostgreSqlLiveTest
 */
class PostgreSqlLiveTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Test ini khusus PostgreSQL. Lewati otomatis bila driver lain.
        if (DB::connection()->getDriverName() !== 'pgsql') {
            $this->markTestSkipped('Test ini hanya berjalan di PostgreSQL.');
        }
    }

    public function test_database_yang_dipakai_adalah_postgresql(): void
    {
        $this->assertSame('pgsql', DB::connection()->getDriverName());
    }

    public function test_enum_status_sesuai_kontroler(): void
    {
        $rows = DB::select(
            "SELECT pg_get_constraintdef(oid) AS def FROM pg_constraint
             WHERE conrelid = 'pengaduan'::regclass AND conname = 'pengaduan_status_check'"
        );

        $this->assertNotEmpty($rows);

        foreach (PengaduanController::STATUS as $status) {
            $this->assertStringContainsString("'{$status}'", $rows[0]->def);
        }
    }

    public function test_alur_lengkap_di_postgresql(): void
    {
        // --- Persiapan data dasarial ---
        $dinasId = DB::table('dinas_kesehatan')->insertGetId([
            'nama_dinas' => 'Dinas Test', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $puskesmasId = DB::table('puskesmas')->insertGetId([
            'dinas_kesehatan_id' => $dinasId,
            'nama_puskesmas' => 'PK Test',
            'alamat' => 'Jl. Test',
            'kecamatan' => 'Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@pg.test',
            'password' => bcrypt('rahasia123'),
            'role' => 'tenaga_kesehatan',
            'puskesmas_id' => $puskesmasId,
        ]);

        $this->assertNotNull($admin->puskesmas_id);

        // --- 1. Daftarkan Posyandu ---
        $this->actingAs($admin)
            ->post(route('puskesmas.posyandu.store'), [
                'nama_posyandu' => 'Posyandu Baru',
                'alamat' => 'Jl. Melati',
                'kelurahan' => 'Melati',
                'kecamatan' => 'Melati',
                'telepon' => '081234',
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('posyandu', [
            'nama_posyandu' => 'Posyandu Baru',
            'puskesmas_id' => $puskesmasId,
        ]);

        $posyanduId = DB::table('posyandu')
            ->where('nama_posyandu', 'Posyandu Baru')
            ->value('id');

        $this->assertNotNull($posyanduId);

        // --- 2. Daftarkan Kader untuk Posyandu tersebut ---
        $this->actingAs($admin)
            ->post(route('puskesmas.kader.store'), [
                'name' => 'Kader Test',
                'email' => 'kader@pg.test',
                'password' => 'password123',
                'password_confirmation' => 'password123',
                'posyandu_id' => $posyanduId,
            ])
            ->assertSessionHasNoErrors();

        $this->assertDatabaseHas('users', ['email' => 'kader@pg.test', 'role' => 'kader']);

        // --- 3. Kader bisa login ---
        $this->post(route('login'), [
            'email' => 'kader@pg.test',
            'password' => 'password123',
        ])->assertRedirect();

        $this->assertAuthenticated();

        // --- 4. Dashboard terbuka ---
        $this->actingAs($admin)
            ->get(route('puskesmas.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Puskesmas');

        // --- 5. Pengaduan + pencarian case-insensitive (uji LOWER LIKE di PG) ---
        $warga = User::create([
            'name' => 'Warga',
            'email' => 'warga@pg.test',
            'password' => bcrypt('rahasia123'),
            'role' => 'keluarga',
            'posyandu_id' => $posyanduId,
        ]);

        DB::table('pengaduan')->insert([
            'pelapor_id' => $warga->id,
            'posyandu_id' => $posyanduId,
            'judul' => 'Air Bersih Mati',
            'deskripsi' => 'Tidak mengalir sejak seminggu',
            'jenis' => 'layanan',
            'status' => 'baru',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->actingAs($admin)
            ->get(route('puskesmas.pengaduan.index', ['search' => 'BERSIH']))
            ->assertOk()
            ->assertSee('Air Bersih Mati');

        // --- 6. Tipelago balasan pengaduan ---
        $pengaduanId = DB::table('pengaduan')->value('id');

        $this->actingAs($admin)
            ->put(route('puskesmas.pengaduan.update', $pengaduanId), [
                'status' => 'diproses',
                'tanggapan_puskesmas' => 'Sudah kami tangani bersama tim.',
            ])
            ->assertRedirect();

        $this->assertDatabaseHas('pengaduan', [
            'id' => $pengaduanId,
            'status' => 'diproses',
        ]);
    }
}