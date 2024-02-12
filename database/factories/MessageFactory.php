<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class MessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'author_id' => User::factory()->create()->id,
            'content' => fake()->sentence(),
            'is_private' => false,
            'allow_comments' => true,
        ];
    }

    /**
     * Indicate that the user is suspended.
     */
    public function private(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'is_private' => true,
            ];
        });
    }

    /**
     * Indicate that the user is suspended.
     */
    public function noComments(): Factory
    {
        return $this->state(function (array $attributes) {
            return [
                'allow_comments' => false,
            ];
        });
    }
}
