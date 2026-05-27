<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class PrestamoFactory extends Factory
{
    /**
     * Define the model's default state.
     */

    public function definition(): array
    {
        /*
        |--------------------------------------------------------------------------
        | Estados reales
        |--------------------------------------------------------------------------
        |
        | retrasado NO se genera manualmente.
        | El sistema lo calcula automáticamente.
        |
        */

        $estado = $this->faker->randomElement([
            'activo',
            'devuelto',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Fecha préstamo
        |--------------------------------------------------------------------------
        */

        $fechaPrestamo = $this->faker
            ->dateTimeBetween('-2 months', 'now');

        /*
        |--------------------------------------------------------------------------
        | Fecha devolución
        |--------------------------------------------------------------------------
        */

        $fechaDevolucion = null;

        /*
        |--------------------------------------------------------------------------
        | DEVUELTO
        |--------------------------------------------------------------------------
        */

        if ($estado === 'devuelto') {

            $fechaDevolucion = $this->faker
                ->dateTimeBetween(
                    $fechaPrestamo,
                    'now'
                )
                ->format('Y-m-d');
        }

        /*
        |--------------------------------------------------------------------------
        | ACTIVO
        |--------------------------------------------------------------------------
        |
        | Algunos vencidos.
        | Algunos todavía válidos.
        |
        */

        if ($estado === 'activo') {

            /*
            | 50% vencidos
            */

            if ($this->faker->boolean()) {

                /*
                | Fecha pasada
                */

                $fechaDevolucion = $this->faker
                    ->dateTimeBetween(
                        '-20 days',
                        '-1 day'
                    )
                    ->format('Y-m-d');

            } else {

                /*
                | Fecha futura
                */

                $fechaDevolucion = $this->faker
                    ->dateTimeBetween(
                        'tomorrow',
                        '+20 days'
                    )
                    ->format('Y-m-d');
            }
        }

        return [

            'user_id' => \App\Models\User
                ::inRandomOrder()
                ->value('id'),

            'libro_id' => \App\Models\Libro
                ::inRandomOrder()
                ->value('id'),

            'fecha_prestamo' =>
                $fechaPrestamo->format('Y-m-d'),

            'fecha_devolucion' =>
                $fechaDevolucion,

            'estado' => $estado,
        ];
    }
}
