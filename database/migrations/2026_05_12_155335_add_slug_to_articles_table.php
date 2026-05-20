<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use App\Models\Article;

return new class extends Migration
{
    public function up(): void
    {
        // Guard: skip jika kolom slug sudah ada (misal, sudah dijalankan manual di server)
        if (!Schema::hasColumn('articles', 'slug')) {
            Schema::table('articles', function (Blueprint $table) {
                $table->string('slug')->nullable()->unique()->after('title');
            });

            // Isi slug untuk artikel lama yang sudah ada di database
            Article::whereNull('slug')->get()->each(function ($article) {
                $article->update(['slug' => Str::slug($article->title) . '-' . $article->id]);
            });

            // Setelah semua data terisi, ubah menjadi non-nullable
            Schema::table('articles', function (Blueprint $table) {
                $table->string('slug')->nullable(false)->change();
            });
        }
    }

    public function down(): void
    {
        Schema::table('articles', function (Blueprint $table) {
            $table->dropColumn('slug');
        });
    }
};
