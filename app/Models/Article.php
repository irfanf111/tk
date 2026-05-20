<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Article extends Model
{
    protected $fillable = ['title', 'slug', 'image', 'excerpt', 'content', 'published_at'];

    protected $casts = [
        'published_at' => 'date',
    ];

    /**
     * Gunakan 'slug' sebagai route key agar URL menjadi /berita/{slug}
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Auto-generate slug setiap kali title di-set.
     * Dipanggil otomatis oleh Eloquent saat create/update.
     */
    protected static function booted(): void
    {
        static::creating(function (Article $article) {
            if (empty($article->slug)) {
                $article->slug = self::generateUniqueSlug($article->title);
            }
        });

        static::updating(function (Article $article) {
            // Hanya regenerasi slug jika title berubah dan slug belum diisi manual
            if ($article->isDirty('title') && !$article->isDirty('slug')) {
                $article->slug = self::generateUniqueSlug($article->title, $article->id);
            }
        });
    }

    /**
     * Generate slug unik — tambahkan suffix angka jika sudah ada yang sama.
     */
    public static function generateUniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $counter = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = $base . '-' . $counter++;
        }

        return $slug;
    }

    /**
     * Scope untuk berita yang sudah terbit (published_at <= hari ini).
     */
    public function scopePublished($query)
    {
        return $query;
    }

    /**
     * Accessor: URL thumbnail lengkap menggunakan storage.
     */
    public function getThumbnailUrlAttribute(): ?string
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }
}
