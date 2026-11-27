<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class PuskesmasSidebarAccountTest extends TestCase
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
            'email' => 'account.test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'tenaga_kesehatan',
            'puskesmas_id' => $puskesmasId,
        ]);
    }

    public function test_account_profile_link_is_above_logout_in_the_sidebar(): void
    {
        $html = $this->actingAs($this->makeUser())
            ->get(route('puskesmas.dashboard'))
            ->assertOk()
            ->getContent();

        $profileLinkPosition = strpos($html, 'href="'.route('profile').'"');
        $logoutFormPosition = strpos($html, 'action="'.route('logout').'"');

        $this->assertNotFalse($profileLinkPosition);
        $this->assertNotFalse($logoutFormPosition);
        $this->assertTrue($profileLinkPosition < $logoutFormPosition);
        $this->assertStringContainsString('Profil akun · Puskesmas', $html);
    }
}
