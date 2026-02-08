<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Usuarios aleatorios
        User::factory(10)->create()->each(function ($user) {
            $user->assignRole('Usuario');
        });

        //Usuario administrador
        User::create([
            'nombre' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => Hash::make('123456789'),
        ])->assignRole('Admin');

        //Usuario con rol bibliotecario
        User::create([
            'nombre' => 'Bibliotecario',
            'email' => 'bibliotecario@bibliotecario.com',
            'password' => Hash::make('123456789'),
        ])->assignRole('Bibliotecario');

        //Usuario por defecto para peticiones
        User::create([
            'nombre' => 'Usuario',
            'email' => 'usuario@usuario.com',
            'password' => Hash::make('123456789'),
        ])->assignRole('Usuario');
    }
}
