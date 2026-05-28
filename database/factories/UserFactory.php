<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Str;

use Faker\Factory as Faker;

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
        $faker = Faker::create();

        return [

            'nombre' => $faker->name(),

            'direccion' => $faker->streetAddress(),

            'telefono' => $faker->numerify('6########'),

            'email' => $faker->unique()->safeEmail(),

            'email_verified_at' => now(),

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
