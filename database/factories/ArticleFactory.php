<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'slug' => Str::slug(fake()->unique()->word()),
            'title' => fake()->unique()->sentence(),
            'content' => fake()->unique()->sentence(),
            'author_id' => User::factory()->create()->id,
            'published_at' => fake()->dateTimeBetween(),
        ];
    }

    /**
     * Indicate that the user is suspended.
     */
    public function notPublished(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'published_at' => fake()->dateTimeBetween('+1 month', '+5 year'),
            ];
        });
    }
}
