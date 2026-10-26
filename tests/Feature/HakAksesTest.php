<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian kontrol hak akses (authorization).
 * Memastikan halaman admin tidak bisa diakses oleh tamu dan user biasa.
 * Admin panel menggunakan Filament dengan gate canAccessPanel().
 */
class HakAksesTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────────
    // Tamu (belum login)
    // ─────────────────────────────────────────────────────────────────────────

    /** @test */
    public function test_tamu_tidak_bisa_mengakses_panel_admin_dan_diredirect_ke_login()
    {
        $response = $this->get('/admin');

        // Filament redirect tamu ke halaman login Filament
        $response->assertRedirect();
        $this->assertStringContainsString('login', $response->headers->get('Location') ?? '');
    }

    /** @test */
    public function test_tamu_bisa_mengakses_halaman_ppdb_publik()
    {
        $response = $this->get(route('ppdb.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function test_tamu_bisa_mengakses_halaman_berita()
    {
        $response = $this->get(route('berita.index'));
        $response->assertStatus(200);
    }

    /** @test */
    public function test_tamu_bisa_mengakses_halaman_form_lpad()
    {
        $response = $this->get(route('reports.create'));
        $response->assertStatus(200);
    }

    /** @test */
    public function test_tamu_bisa_mengakses_halaman_login()
    {
        $response = $this->get(route('login'));
        $response->assertStatus(200);
    }

    /** @test */
    public function test_tamu_bisa_mengakses_halaman_register()
    {
        $response = $this->get(route('register'));
        $response->assertStatus(200);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Role logic (canAccessPanel)
    // ─────────────────────────────────────────────────────────────────────────

    /** @test */
    public function test_user_dengan_role_admin_bisa_mengakses_panel_filament()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        // Metode canAccessPanel harus mengembalikan true untuk admin
        $this->assertTrue($admin->canAccessPanel(app(\Filament\Panel::class)));
    }

    /** @test */
    public function test_user_dengan_role_user_tidak_bisa_mengakses_panel_filament()
    {
        $user = User::factory()->create(['role' => 'user']);

        // Metode canAccessPanel harus mengembalikan false untuk role user
        $this->assertFalse($user->canAccessPanel(app(\Filament\Panel::class)));
    }

    /** @test */
    public function test_user_dengan_role_superadmin_bisa_mengakses_panel_filament()
    {
        $superAdmin = User::factory()->create(['role' => 'superadmin']);

        $this->assertTrue($superAdmin->canAccessPanel(app(\Filament\Panel::class)));
    }

    /** @test */
    public function test_helper_is_admin_mengembalikan_true_untuk_role_admin()
    {
        $admin = User::factory()->create(['role' => 'admin']);
        $this->assertTrue($admin->isAdmin());
    }

    /** @test */
    public function test_helper_is_admin_mengembalikan_false_untuk_role_user()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->assertFalse($user->isAdmin());
    }

    // ─────────────────────────────────────────────────────────────────────────
    // User yang sudah login redirect dari login/register
    // ─────────────────────────────────────────────────────────────────────────

    /** @test */
    public function test_user_yang_sudah_login_diredirect_dari_halaman_login()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('login'));

        // Harus redirect (bukan menampilkan form login)
        $response->assertRedirect();
    }

    /** @test */
    public function test_user_yang_sudah_login_diredirect_dari_halaman_register()
    {
        $user = User::factory()->create(['role' => 'user']);
        $this->actingAs($user);

        $response = $this->get(route('register'));

        $response->assertRedirect();
    }
}
