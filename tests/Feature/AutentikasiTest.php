<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian fitur autentikasi: login, register, logout.
 */
class AutentikasiTest extends TestCase
{
    use RefreshDatabase;

    // ─────────────────────────────────────────────────────────────────────────
    // LOGIN
    // ─────────────────────────────────────────────────────────────────────────

    /** @test */
    public function test_login_berhasil_dengan_kredensial_valid()
    {
        $user = User::factory()->create([
            'email'    => 'user@test.com',
            'password' => bcrypt('password123'),
            'role'     => 'user',
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'user@test.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect(route('ppdb.user.index'));
        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    public function test_login_admin_diarahkan_ke_panel_admin()
    {
        $admin = User::factory()->create([
            'email'    => 'admin@test.com',
            'password' => bcrypt('adminpass'),
            'role'     => 'admin',
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'admin@test.com',
            'password' => 'adminpass',
        ]);

        $response->assertRedirect('/admin');
        $this->assertAuthenticatedAs($admin);
    }

    /** @test */
    public function test_login_gagal_jika_password_salah()
    {
        User::factory()->create([
            'email'    => 'user@test.com',
            'password' => bcrypt('password_benar'),
        ]);

        $response = $this->post(route('login'), [
            'email'    => 'user@test.com',
            'password' => 'password_salah',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /** @test */
    public function test_login_gagal_jika_email_tidak_terdaftar()
    {
        $response = $this->post(route('login'), [
            'email'    => 'tidakada@test.com',
            'password' => 'apapun',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /** @test */
    public function test_login_gagal_jika_email_tidak_diisi()
    {
        $response = $this->post(route('login'), [
            'email'    => '',
            'password' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // REGISTER
    // ─────────────────────────────────────────────────────────────────────────

    /** @test */
    public function test_registrasi_berhasil_dengan_data_valid()
    {
        $response = $this->post(route('register'), [
            'name'                  => 'Budi Santoso',
            'email'                 => 'budi@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertRedirect(route('ppdb.user.index'));
        $this->assertDatabaseHas('users', [
            'email' => 'budi@test.com',
            'name'  => 'Budi Santoso',
            'role'  => 'user',
        ]);
        $this->assertAuthenticated();
    }

    /** @test */
    public function test_registrasi_gagal_jika_email_sudah_terdaftar()
    {
        User::factory()->create(['email' => 'sudahada@test.com']);

        $response = $this->post(route('register'), [
            'name'                  => 'User Lain',
            'email'                 => 'sudahada@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    /** @test */
    public function test_registrasi_gagal_jika_password_tidak_cocok()
    {
        $response = $this->post(route('register'), [
            'name'                  => 'Coba User',
            'email'                 => 'coba@test.com',
            'password'              => 'password123',
            'password_confirmation' => 'berbeda456',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    /** @test */
    public function test_registrasi_gagal_jika_password_kurang_dari_8_karakter()
    {
        $response = $this->post(route('register'), [
            'name'                  => 'Coba User',
            'email'                 => 'coba@test.com',
            'password'              => '123',
            'password_confirmation' => '123',
        ]);

        $response->assertSessionHasErrors(['password']);
        $this->assertGuest();
    }

    // ─────────────────────────────────────────────────────────────────────────
    // LOGOUT
    // ─────────────────────────────────────────────────────────────────────────

    /** @test */
    public function test_logout_berhasil_dan_redirect_ke_halaman_login()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }
}
