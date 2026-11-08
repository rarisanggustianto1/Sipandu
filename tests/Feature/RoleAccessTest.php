<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RoleAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_redirects_each_role_to_its_dashboard(): void
    {
        $dinasId = DB::table('dinas_kesehatan')->insertGetId([
            'nama_dinas' => 'Dinas Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        $puskesmasId = DB::table('puskesmas')->insertGetId([
            'dinas_kesehatan_id' => $dinasId,
            'nama_puskesmas' => 'Puskesmas Test',
            'alamat' => 'Alamat Test',
            'kecamatan' => 'Kecamatan Test',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $roleRoutes = [
            'dinas_kesehatan' => route('dinas.dashboard'),
            'tenaga_kesehatan' => route('puskesmas.dashboard'),
            'kader' => route('kader.pemeriksaan.index'),
            'keluarga' => route('peserta.dashboard'),
        ];

        foreach ($roleRoutes as $role => $destination) {
            $user = User::factory()->create([
                'role' => $role,
                'puskesmas_id' => $role === 'tenaga_kesehatan' ? $puskesmasId : null,
            ]);

            $this->actingAs($user)
                ->get('/')
                ->assertRedirect($destination);
        }
    }

    public function test_login_redirects_peserta_to_their_dashboard(): void
    {
        User::factory()->create([
            'email' => 'peserta@example.com',
            'password' => Hash::make('password123'),
            'role' => 'keluarga',
        ]);

        $this->get(route('dinas.dashboard'))
            ->assertRedirect(route('login'));

        $this->post('/login', [
            'email' => 'peserta@example.com',
            'password' => 'password123',
        ])->assertRedirect(route('home'));

        $this->get(route('home'))
            ->assertRedirect(route('peserta.dashboard'));
    }

    public function test_users_cannot_access_modules_for_other_roles(): void
    {
        $cases = [
            ['kader', '/dinas'],
            ['dinas_kesehatan', '/kader/pemeriksaan'],
            ['keluarga', '/puskesmas/dashboard'],
            ['tenaga_kesehatan', '/peserta'],
        ];

        foreach ($cases as [$role, $path]) {
            $user = User::factory()->create(['role' => $role]);

            $this->actingAs($user)
                ->get($path)
                ->assertForbidden();
        }
    }

    public function test_puskesmas_user_without_an_assignment_is_denied_access(): void
    {
        $user = User::factory()->create([
            'role' => 'tenaga_kesehatan',
            'puskesmas_id' => null,
        ]);

        $this->actingAs($user)
            ->get(route('home'))
            ->assertRedirect(route('profile'));

        $this->get(route('puskesmas.dashboard'))
            ->assertForbidden();
    }

    public function test_dinas_dashboard_has_a_logout_button_that_ends_the_session(): void
    {
        $user = User::factory()->create(['role' => 'dinas_kesehatan']);

        $this->actingAs($user)
            ->get(route('dinas.dashboard'))
            ->assertOk()
            ->assertSee('action="'.route('logout').'"', escape: false)
            ->assertSee('<button type="submit"', escape: false)
            ->assertSee('Keluar');

        $this->post(route('logout'))
            ->assertRedirect('/');

        $this->get(route('dinas.dashboard'))
            ->assertRedirect(route('login'));
    }

    public function test_demo_accounts_can_log_in_and_open_their_role_dashboards(): void
    {
        $this->seed(DatabaseSeeder::class);
        $this->seed(DatabaseSeeder::class);

        $roleRoutes = [
            'dinas@gmail.com' => route('dinas.dashboard'),
            'puskesmas@gmail.com' => route('puskesmas.dashboard'),
            'kader@gmail.com' => route('kader.pemeriksaan.index'),
            'peserta@gmail.com' => route('peserta.dashboard'),
        ];

        $this->assertSame(4, User::whereIn('email', array_keys($roleRoutes))->count());
        $this->assertNotNull(User::where('email', 'puskesmas@gmail.com')->value('puskesmas_id'));
        $this->assertNotNull(User::where('email', 'kader@gmail.com')->value('posyandu_id'));
        $this->assertNotNull(User::where('email', 'peserta@gmail.com')->value('keluarga_id'));

        foreach ($roleRoutes as $email => $dashboard) {
            $this->post('/login', [
                'email' => $email,
                'password' => 'password123',
            ])->assertRedirect(route('home'));

            $this->get(route('home'))->assertRedirect($dashboard);
            $this->get($dashboard)->assertOk();

            $this->post('/logout')->assertRedirect('/');
        }
    }
}
