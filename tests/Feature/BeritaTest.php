<?php

namespace Tests\Feature;

use App\Models\Article;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian fitur berita/artikel: tampil di halaman publik.
 * (Manajemen artikel dilakukan via Filament, bukan controller biasa,
 *  sehingga test difokuskan pada tampilan publik yang pakai custom controller)
 */
class BeritaTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_halaman_berita_dapat_diakses_tanpa_login()
    {
        $response = $this->get(route('berita.index'));

        $response->assertStatus(200);
    }

    /** @test */
    public function test_artikel_yang_sudah_dipublikasikan_tampil_di_halaman_berita()
    {
        $article = Article::factory()->create([
            'title'        => 'Berita Kegiatan TK Puspitasari',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('berita.index'));

        $response->assertStatus(200);
        $response->assertSee('Berita Kegiatan TK Puspitasari');
    }

    /** @test */
    public function test_artikel_yang_belum_dipublikasikan_tidak_tampil_di_halaman_berita()
    {
        $articleTampil = Article::factory()->create([
            'title'        => 'Artikel Sudah Terbit',
            'published_at' => now()->subDay(),
        ]);

        $articleBelum = Article::factory()->create([
            'title'        => 'Artikel Belum Terbit',
            'published_at' => now()->addDays(7),
        ]);

        $response = $this->get(route('berita.index'));

        $response->assertStatus(200);
        $response->assertSee('Artikel Sudah Terbit');
        $response->assertDontSee('Artikel Belum Terbit');
    }

    /** @test */
    public function test_halaman_detail_artikel_dapat_diakses_via_slug()
    {
        $article = Article::factory()->create([
            'title'        => 'Artikel Detail Test',
            'slug'         => 'artikel-detail-test',
            'published_at' => now()->subDay(),
        ]);

        $response = $this->get(route('berita.show', ['article' => $article->slug]));

        $response->assertStatus(200);
        $response->assertSee('Artikel Detail Test');
    }

    /** @test */
    public function test_slug_artikel_dibuat_otomatis_saat_artikel_dibuat()
    {
        $article = Article::create([
            'title'        => 'Judul Artikel Tanpa Slug Manual',
            'excerpt'      => 'Ringkasan artikel.',
            'content'      => 'Isi artikel lengkap.',
            'published_at' => now(),
        ]);

        $this->assertNotNull($article->slug);
        $this->assertStringContainsString('judul-artikel-tanpa-slug-manual', $article->slug);
    }

    /** @test */
    public function test_slug_artikel_unik_jika_judul_sama()
    {
        $article1 = Article::create([
            'title'        => 'Judul Sama',
            'excerpt'      => 'Ringkasan.',
            'content'      => 'Isi.',
            'published_at' => now(),
        ]);

        $article2 = Article::create([
            'title'        => 'Judul Sama',
            'excerpt'      => 'Ringkasan.',
            'content'      => 'Isi.',
            'published_at' => now(),
        ]);

        $this->assertNotEquals($article1->slug, $article2->slug);
    }
}
