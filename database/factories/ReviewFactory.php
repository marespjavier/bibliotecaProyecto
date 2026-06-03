<?php

namespace Database\Factories;

use App\Models\Libro;
use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [

            'user_id' => User::inRandomOrder()->first()->id,

            'libro_id' => Libro::inRandomOrder()->first()->id,

            'rating' => fake()->numberBetween(1, 5),

            'comentario' => fake()->paragraph(3),
        ];
    }
}
