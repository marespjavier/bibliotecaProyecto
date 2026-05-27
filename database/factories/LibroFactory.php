<?php

namespace Database\Factories;

use App\Models\Autor;
use App\Models\Categoria;
use App\Models\Libro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Libro>
 */
class LibroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        return [

            'titulo' =>
                $this->faker->sentence(3),

            'isbn' =>
                $this->faker->unique()->isbn13(),

            'anyo_publicacion' =>
                $this->faker->numberBetween(1950, 2026),

            'descripcion' =>
                $this->faker->paragraph(3),

            /*
            |--------------------------------------------------------------------------
            | Imagen portada fake
            |--------------------------------------------------------------------------
            */

            'imagen_url' =>
                'https://picsum.photos/300/450?random=' .
                rand(1, 1000),

            /*
            |--------------------------------------------------------------------------
            | Relaciones
            |--------------------------------------------------------------------------
            */

            'autor_id' =>
                Autor::query()
                    ->inRandomOrder()
                    ->value('id'),

            'categoria_id' =>
                Categoria::query()
                    ->inRandomOrder()
                    ->value('id'),
        ];
    }
}
