<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Str;
use App\Models\Article;

return new class extends Migration
{
    /**
     * Isi slug untuk artikel lama yang masih NULL di database production.
     * Migrasi ini idempoten — aman dijalankan berkali-kali.
     */
    public function up(): void
    {
        Article::whereNull('slug')->get()->each(function (Article $article) {
            $base = Str::slug($article->title);
            $slug = $base ?: 'artikel-' . $article->id;
            $counter = 1;

            // Pastikan slug unik
            while (Article::where('slug', $slug)->where('id', '!=', $article->id)->exists()) {
                $slug = $base . '-' . $counter++;
            }

            // Bypass model events — update langsung ke DB agar lebih cepat
            Article::where('id', $article->id)->update(['slug' => $slug]);
        });
    }

    public function down(): void
    {
        // Tidak ada rollback — data slug tidak dihapus
    }
};
