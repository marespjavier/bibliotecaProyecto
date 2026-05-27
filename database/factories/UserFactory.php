<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
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

            'telefono' => fake()->phoneNumber(),

            'email' => fake()->unique()->safeEmail(),

            'email_verified_at' => now(),

            /*
            |--------------------------------------------------------------------------
            | Avatar temporal
            |--------------------------------------------------------------------------
            |
            | Después se reemplaza en UserSeeder
            | usando el ID real del usuario.
            |
            */

            'avatar_url' => null,

            'password' => Hash::make('123456789'),

            'remember_token' => Str::random(10),

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
