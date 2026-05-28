<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

/**
 * @extends Factory<User>
 */
class UserFactory extends Factory
{
    /*
    |--------------------------------------------------------------------------
    | Password actual
    |--------------------------------------------------------------------------
    */

    protected static ?string $password;

    /*
    |--------------------------------------------------------------------------
    | Definición modelo
    |--------------------------------------------------------------------------
    */

    public function definition(): array
    {
        return [

            'nombre' => fake()->name(),

            'direccion' => fake()->streetAddress(),

            'telefono' => fake()->numerify('6########'),

            'email' => fake()->unique()->safeEmail(),
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Email no verificado
    |--------------------------------------------------------------------------
    */

    public function unverified(): static
    {
        return $this->state(
            fn (array $attributes) => [

                'email_verified_at' => null,

            ]
        );
    }
}
