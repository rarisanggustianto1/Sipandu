<?php

namespace Tests\Feature;

use App\Models\Dinas\DinasKesehatan;
use App\Models\Puskesmas\Puskesmas;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DinasPuskesmasManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(DatabaseSeeder::class);
    }

    public function test_puskesmas_is_assigned_to_the_logged_in_dinas_without_a_dinas_selector(): void
    {
        $dinasUser = User::where('email', 'dinas@gmail.com')->firstOrFail();
        $otherDinas = DinasKesehatan::create([
            'nama_dinas' => 'Dinas Lain',
        ]);

        $this->actingAs($dinasUser)
            ->get(route('dinas.puskesmas.create'))
            ->assertOk()
            ->assertSee('Dinas Kesehatan Demo')
            ->assertSee('Puskesmas ini otomatis terhubung')
            ->assertDontSee('name="dinas_kesehatan_id"', false);

        $this->actingAs($dinasUser)
            ->post(route('dinas.puskesmas.store'), [
                'dinas_kesehatan_id' => $otherDinas->id,
                'nama_puskesmas' => 'Puskesmas Otomatis',
                'alamat' => 'Alamat Puskesmas Otomatis',
                'kecamatan' => 'Kecamatan Demo',
                'telepon' => '08123456789',
                'email' => 'puskesmas.otomatis@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertRedirect(route('dinas.puskesmas.index'));

        $this->assertDatabaseHas('puskesmas', [
            'nama_puskesmas' => 'Puskesmas Otomatis',
            'dinas_kesehatan_id' => $dinasUser->dinas_kesehatan_id,
            'email' => 'puskesmas.otomatis@example.com',
        ]);
        $this->assertDatabaseMissing('puskesmas', [
            'nama_puskesmas' => 'Puskesmas Otomatis',
            'dinas_kesehatan_id' => $otherDinas->id,
        ]);
    }

    public function test_edit_keeps_the_dinas_assignment_and_limits_puskesmas_to_the_logged_in_dinas(): void
    {
        $dinasUser = User::where('email', 'dinas@gmail.com')->firstOrFail();
        $otherDinas = DinasKesehatan::create([
            'nama_dinas' => 'Dinas Lain',
        ]);
        $otherPuskesmas = Puskesmas::create([
            'dinas_kesehatan_id' => $otherDinas->id,
            'nama_puskesmas' => 'Puskesmas Dinas Lain',
            'alamat' => 'Alamat Dinas Lain',
            'kecamatan' => 'Kecamatan Lain',
        ]);
        $puskesmas = Puskesmas::where('dinas_kesehatan_id', $dinasUser->dinas_kesehatan_id)->firstOrFail();

        $this->actingAs($dinasUser)
            ->get(route('dinas.puskesmas.index'))
            ->assertOk()
            ->assertSee($puskesmas->nama_puskesmas)
            ->assertDontSee($otherPuskesmas->nama_puskesmas);

        $this->actingAs($dinasUser)
            ->get(route('dinas.puskesmas.edit', $puskesmas))
            ->assertOk()
            ->assertSee('Dinas Kesehatan Demo')
            ->assertDontSee('name="dinas_kesehatan_id"', false);

        $this->actingAs($dinasUser)
            ->get(route('dinas.puskesmas.edit', $otherPuskesmas))
            ->assertNotFound();

        $this->actingAs($dinasUser)
            ->put(route('dinas.puskesmas.update', $puskesmas), [
                'dinas_kesehatan_id' => $otherDinas->id,
                'nama_puskesmas' => 'Puskesmas Diperbarui',
                'alamat' => 'Alamat Baru',
                'kecamatan' => 'Kecamatan Baru',
                'telepon' => '08123456789',
                'email' => 'puskesmas.demo@example.com',
            ])
            ->assertRedirect(route('dinas.puskesmas.index'));

        $this->assertDatabaseHas('puskesmas', [
            'id' => $puskesmas->id,
            'nama_puskesmas' => 'Puskesmas Diperbarui',
            'dinas_kesehatan_id' => $dinasUser->dinas_kesehatan_id,
        ]);
    }

    public function test_dinas_account_without_a_dinas_assignment_cannot_create_a_puskesmas(): void
    {
        $dinasUser = User::create([
            'name' => 'Dinas Tanpa Relasi',
            'email' => 'dinas.tanpa.relasi@example.com',
            'password' => 'password123',
            'role' => 'dinas_kesehatan',
        ]);

        $this->actingAs($dinasUser)
            ->get(route('dinas.puskesmas.create'))
            ->assertForbidden();

        $this->actingAs($dinasUser)
            ->post(route('dinas.puskesmas.store'), [
                'nama_puskesmas' => 'Puskesmas Tidak Sah',
                'alamat' => 'Alamat',
                'kecamatan' => 'Kecamatan',
                'email' => 'puskesmas.tidak.sah@example.com',
                'password' => 'password123',
                'password_confirmation' => 'password123',
            ])
            ->assertForbidden();
    }
}
