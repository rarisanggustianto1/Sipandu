<?php

namespace Tests\Feature\Auth;

use App\Models\Peserta\Keluarga;
use App\Models\Puskesmas\Posyandu;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_registration_screen_can_be_rendered(): void
    {
        $response = $this->get('/register');

        $response->assertOk()
            ->assertSee('Buat password')
            ->assertSee('Nomor KK');
    }

    public function test_family_can_register_with_its_own_password_and_add_members(): void
    {
        $posyandu = Posyandu::firstOrFail();

        $response = $this->post('/register', [
            'no_kk' => '1871000000000099',
            'nama_kepala_keluarga' => 'Keluarga Daftar Mandiri',
            'posyandu_id' => $posyandu->id,
            'alamat' => 'Alamat Keluarga Daftar Mandiri',
            'no_telepon' => '08123456789',
            'password' => 'password-keluarga',
            'password_confirmation' => 'password-keluarga',
        ]);

        $response->assertRedirect(route('home'));
        $user = User::where('role', 'keluarga')->whereNull('email')->firstOrFail();
        $family = Keluarga::where('no_kk', '1871000000000099')->firstOrFail();

        $this->assertAuthenticatedAs($user);
        $this->assertSame($family->id, $user->keluarga_id);
        $this->assertSame($posyandu->id, $family->posyandu_id);
        $this->assertTrue(Hash::check('password-keluarga', $user->password));

        $this->post(route('peserta.data.store'), [
            'nik' => '1871010101240099',
            'nama' => 'Anggota Daftar Mandiri',
            'jenis_kelamin' => 'P',
            'tanggal_lahir' => '2024-01-01',
            'kategori' => 'balita',
        ])->assertRedirect();

        $this->assertDatabaseHas('peserta', [
            'keluarga_id' => $family->id,
            'nik' => '1871010101240099',
        ]);
    }

    public function test_family_cannot_register_a_duplicate_household_number(): void
    {
        $this->from('/register')
            ->post('/register', [
                'no_kk' => '0000000000000001',
                'nama_kepala_keluarga' => 'Nomor KK Terdaftar',
                'posyandu_id' => Posyandu::firstOrFail()->id,
                'alamat' => 'Alamat',
                'password' => 'password-keluarga',
                'password_confirmation' => 'password-keluarga',
            ])
            ->assertSessionHasErrors('no_kk');

        $this->assertGuest();
    }
}
