<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;

use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | Usuarios aleatorios
        |--------------------------------------------------------------------------
        */

        User::factory(10)->create()->each(function ($user) {

            $user->assignRole('Usuario');
        });

        /*
        |--------------------------------------------------------------------------
        | Usuario administrador
        |--------------------------------------------------------------------------
        */

        User::create([

            'nombre' => 'Administrador',

            'email' => 'admin@admin.com',

            'password' => Hash::make('123456789'),

            'avatar_url' =>
                'https://i.pravatar.cc/300?img=11',

        ])->assignRole('Admin');

        /*
        |--------------------------------------------------------------------------
        | Usuario bibliotecario
        |--------------------------------------------------------------------------
        */

        User::create([

            'nombre' => 'Bibliotecario',

            'email' =>
                'bibliotecario@bibliotecario.com',

            'password' => Hash::make('123456789'),

            'avatar_url' =>
                'https://i.pravatar.cc/300?img=12',

        ])->assignRole('Bibliotecario');

        /*
        |--------------------------------------------------------------------------
        | Usuario por defecto
        |--------------------------------------------------------------------------
        */

        User::create([

            'nombre' =>
                'Javier Martinez Espinosa',

            'email' =>
                'javierme.97@iespacomolla.es',

            'direccion' =>
                'Calle Román, Número 14A',

            'telefono' =>
                '608901929',

            'password' =>
                Hash::make('123456789'),

            'avatar_url' =>
                'https://i.pravatar.cc/300?img=13',

        ])->assignRole('Usuario');

        /*
        |--------------------------------------------------------------------------
        | Generar avatares únicos
        |--------------------------------------------------------------------------
        |
        | Usamos el ID del usuario
        | para mantener avatares fijos.
        |
        */

        User::all()->each(function ($user) {

            /*
            |--------------------------------------------------------------------------
            | Saltar usuarios manuales
            |--------------------------------------------------------------------------
            */

            if ($user->avatar_url) {
                return;
            }

            $user->update([

                'avatar_url' =>

                    'https://i.pravatar.cc/300?img=' .

                    (($user->id % 70) + 1)

            ]);
        });
    }
}
