<?php

namespace Tests\Feature;

use App\Models\Puskesmas\Posyandu;
use App\Models\Puskesmas\Puskesmas;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class PerbaikanBugTest extends TestCase
{
    use RefreshDatabase;

    private function buatData(): array
    {
        $dinasId = DB::table('dinas_kesehatan')->insertGetId([
            'nama_dinas' => 'Dinas Kesehatan Test',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $puskesmasId = DB::table('puskesmas')->insertGetId([
            'dinas_kesehatan_id' => $dinasId,
            'nama_puskesmas' => 'Puskesmas Test',
            'alamat' => 'Jl. Test', 'kecamatan' => 'Test',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $posyanduId = DB::table('posyandu')->insertGetId([
            'puskesmas_id' => $puskesmasId,
            'nama_posyandu' => 'Posyandu Melati',
            'alamat' => 'Jl. Melati', 'kelurahan' => 'Melati', 'kecamatan' => 'Melati',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $user = User::create([
            'name' => 'Admin Puskesmas',
            'email' => 'admin.puskesmas@example.com',
            'password' => bcrypt('password123'),
            'role' => 'tenaga_kesehatan',
            'puskesmas_id' => $puskesmasId,
        ]);

        $pelapor = User::create([
            'name' => 'Warga Korban',
            'email' => 'warga@example.com',
            'password' => bcrypt('password123'),
            'role' => 'keluarga',
            'posyandu_id' => $posyanduId,
        ]);

        return compact('puskesmasId', 'posyanduId', 'user', 'pelapor');
    }

    private function buatPengaduan(array $s, string $judul = 'Air Bersih Mati', array $extra = []): int
    {
        return DB::table('pengaduan')->insertGetId(array_merge([
            'pelapor_id' => $s['pelapor']->id,
            'posyandu_id' => $s['posyanduId'],
            'judul' => $judul,
            'deskripsi' => 'Air tidak mengalir sejak seminggu lalu.',
            'jenis' => 'layanan',
            'status' => 'baru',
            'created_at' => now(), 'updated_at' => now(),
        ], $extra));
    }

    public function test_model_posyandu_terdaftar_dan_relasinya_berfungsi(): void
    {
        $this->assertTrue(class_exists(Posyandu::class), 'Model Posyandu harus ada');

        $s = $this->buatData();

        $posyandu = Posyandu::find($s['posyanduId']);

        $this->assertNotNull($posyandu);
        $this->assertSame('Posyandu Melati', $posyandu->nama_posyandu);
        $this->assertInstanceOf(Puskesmas::class, $posyandu->puskesmas);
        $this->assertCount(0, $posyandu->pengaduans);
    }

    public function test_halaman_profil_tidak_error(): void
    {
        $s = $this->buatData();

        // Relasi posyandu() harus ada, sebelumnya memanggilnya fatal error.
        $this->assertTrue(method_exists($s['user'], 'posyandu'));

        $this->actingAs($s['user'])
            ->get(route('profile'))
            ->assertOk();
    }

    public function test_puskesmas_cannot_open_or_respond_to_family_complaints(): void
    {
        $s = $this->buatData();
        $id = $this->buatPengaduan($s, 'Air Bersih Mati');

        $this->actingAs($s['user'])
            ->get('/puskesmas/pengaduan')
            ->assertNotFound();

        $this->actingAs($s['user'])
            ->put("/puskesmas/pengaduan/{$id}", [
                'status' => 'diproses',
                'tanggapan_puskesmas' => 'Tanggapan tidak dapat dikirim melalui akun Puskesmas.',
            ])
            ->assertNotFound();

        $this->assertDatabaseHas('pengaduan', [
            'id' => $id,
            'status' => 'baru',
        ]);
    }

    public function test_daftar_posyandu_does_not_display_complaint_management(): void
    {
        $s = $this->buatData();
        $this->buatPengaduan($s, 'Pengaduan Satu');
        $this->buatPengaduan($s, 'Pengaduan Dua');

        $response = $this->actingAs($s['user'])->get(route('puskesmas.posyandu.index'));

        $response->assertOk();
        $response->assertSee('Posyandu Melati');
        $response->assertDontSee('Pengaduan');
    }

    public function test_existing_complaint_statuses_remain_valid_in_the_database(): void
    {
        $s = $this->buatData();

        $statusList = ['baru', 'diproses', 'selesai'];

        // Setiap status harus benar-benar diterima database (portable, tanpa PRAGMA).
        foreach ($statusList as $status) {
            DB::table('pengaduan')->insert([
                'pelapor_id' => $s['pelapor']->id,
                'posyandu_id' => $s['posyanduId'],
                'judul' => "Pengaduan status {$status}",
                'deskripsi' => 'Deskripsi pengaduan untuk pengujian.',
                'jenis' => 'layanan',
                'status' => $status,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->assertSame(
            count($statusList),
            DB::table('pengaduan')->whereIn('status', $statusList)->count(),
            'Semua status dari controller harus valid di database'
        );

    }

    public function test_daftar_kader_hanya_posyandu_milik_sendiri(): void
    {
        $s = $this->buatData();

        // Posyandu milik Puskesmas lain
        $s['dinasId'] = DB::table('dinas_kesehatan')->insertGetId([
            'nama_dinas' => 'Dinas Kedua', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $puskesmasLain = DB::table('puskesmas')->insertGetId([
            'dinas_kesehatan_id' => $s['dinasId'], 'nama_puskesmas' => 'Puskesmas Lain',
            'alamat' => 'Jl. Lain', 'kecamatan' => 'Lain',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        DB::table('posyandu')->insert([
            'puskesmas_id' => $puskesmasLain, 'nama_posyandu' => 'Posyandu Asing',
            'alamat' => 'Jl. Asing', 'kelurahan' => 'Asing', 'kecamatan' => 'Asing',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $response = $this->actingAs($s['user'])->get(route('puskesmas.kader.create'));

        $response->assertOk();
        $response->assertSee('Posyandu Melati');
        $response->assertDontSee('Posyandu Asing');
    }

    public function test_daftar_kader_menolak_posyandu_milik_puskesmas_lain(): void
    {
        $s = $this->buatData();

        $s['dinasId'] = DB::table('dinas_kesehatan')->insertGetId([
            'nama_dinas' => 'Dinas Kedua', 'created_at' => now(), 'updated_at' => now(),
        ]);

        $puskesmasLain = DB::table('puskesmas')->insertGetId([
            'dinas_kesehatan_id' => $s['dinasId'], 'nama_puskesmas' => 'Puskesmas Lain',
            'alamat' => 'Jl. Lain', 'kecamatan' => 'Lain',
            'created_at' => now(), 'updated_at' => now(),
        ]);
        $asingId = DB::table('posyandu')->insertGetId([
            'puskesmas_id' => $puskesmasLain, 'nama_posyandu' => 'Posyandu Asing',
            'alamat' => 'Jl. Asing', 'kelurahan' => 'Asing', 'kecamatan' => 'Asing',
            'created_at' => now(), 'updated_at' => now(),
        ]);

        $this->actingAs($s['user'])->post(route('puskesmas.kader.store'), [
            'name' => 'Kader Ilegal',
            'email' => 'ilegal@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'posyandu_id' => $asingId,
        ])->assertSessionHasErrors('posyandu_id');

        $this->assertDatabaseMissing('users', ['email' => 'ilegal@example.com']);
    }

    public function test_daftar_kader_menyimpan_kader_dengan_sandi_terenkripsi(): void
    {
        $s = $this->buatData();

        $this->actingAs($s['user'])->post(route('puskesmas.kader.store'), [
            'name' => 'Kader Sah',
            'email' => 'kader@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'posyandu_id' => $s['posyanduId'],
        ])->assertSessionHasNoErrors();

        $kader = User::where('email', 'kader@example.com')->first();

        $this->assertNotNull($kader);
        $this->assertSame('kader', $kader->role);
        $this->assertNotSame('password123', $kader->password, 'Sandi harus di-hash');
        $this->assertTrue(Hash::check('password123', $kader->password));
    }

    public function test_dashboard_tampil_dengan_data(): void
    {
        $s = $this->buatData();
        $this->buatPengaduan($s);

        $this->actingAs($s['user'])
            ->get(route('puskesmas.dashboard'))
            ->assertOk()
            ->assertSee('Dashboard Puskesmas')
            ->assertDontSee('Pengaduan');
    }
}
