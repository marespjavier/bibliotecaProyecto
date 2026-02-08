<?php

namespace Database\Factories;

use App\Models\Libro;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Prestamo>
 */
class PrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $fechaPrestamo = $this->faker->dateTimeBetween('-2 months', 'now');
        $devuelto = $this->faker->boolean(40);

        return [
            'user_id' => \App\Models\User::inRandomOrder()->value('id'),
            'libro_id' => \App\Models\Libro::inRandomOrder()->value('id'),


            'fecha_prestamo' => $fechaPrestamo->format('Y-m-d'),
            'fecha_devolucion' => $devuelto
                ? $this->faker->dateTimeBetween($fechaPrestamo, 'now')->format('Y-m-d')
                : null,

            'estado' => $this->faker->randomElement([
                'activo',
                'devuelto',
                'devuelto',
                'retrasado',
            ]),

        ];
    }
}
