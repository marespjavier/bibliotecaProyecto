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

        $admin = User::firstOrCreate(

            [
                'email' => 'admin@admin.com'
            ],

            [

                'nombre' => 'Administrador',

                'password' => Hash::make('123456789'),

                'avatar_url' =>
                    'https://i.pravatar.cc/300?img=11',

            ]
        );

        $admin->assignRole('Admin');

        /*
        |--------------------------------------------------------------------------
        | Usuario bibliotecario
        |--------------------------------------------------------------------------
        */

        $bibliotecario = User::firstOrCreate(

            [
                'email' =>
                    'bibliotecario@bibliotecario.com'
            ],

            [

                'nombre' => 'Bibliotecario',

                'password' => Hash::make('123456789'),

                'avatar_url' =>
                    'https://i.pravatar.cc/300?img=12',

            ]
        );

        $bibliotecario->assignRole('Bibliotecario');

        /*
        |--------------------------------------------------------------------------
        | Usuario por defecto
        |--------------------------------------------------------------------------
        */

        $usuario = User::firstOrCreate(

            [
                'email' =>
                    'javierme.97@iespacomolla.es'
            ],

            [

                'nombre' =>
                    'Javier Martinez Espinosa',

                'direccion' =>
                    'Calle Román, Número 14A',

                'telefono' =>
                    '608901929',

                'password' =>
                    Hash::make('123456789'),

                'avatar_url' =>
                    'https://i.pravatar.cc/300?img=13',

            ]
        );

        $usuario->assignRole('Usuario');

        /*
        |--------------------------------------------------------------------------
        | Generar avatares únicos
        |--------------------------------------------------------------------------
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
