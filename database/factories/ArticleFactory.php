<?php

namespace Database\Factories;

use App\Models\Article;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Article>
 */
class ArticleFactory extends Factory
{
    protected $model = Article::class;

    public function definition(): array
    {
        $title = $this->faker->sentence();

        return [
            'title'        => $title,
            'slug'         => Str::slug($title) . '-' . $this->faker->unique()->randomNumber(4),
            'image'        => null,
            'excerpt'      => $this->faker->paragraph(),
            'content'      => $this->faker->paragraphs(3, true),
            'published_at' => now()->subDays($this->faker->numberBetween(1, 30)),
        ];
    }

    /**
     * Artikel yang belum dipublikasikan (tanggal di masa depan).
     */
    public function unpublished(): static
    {
        return $this->state(fn (array $attributes) => [
            'published_at' => now()->addDays(7),
        ]);
    }
}
