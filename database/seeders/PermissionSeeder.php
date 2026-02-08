<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'ver_libro',]);
        Permission::create(['name' => 'editar_libro']);
        Permission::create(['name' => 'eliminar_libro']);
        Permission::create(['name' => 'crear_libro']);

        Permission::create(['name' => 'ver_prestamo',]);
        Permission::create(['name' => 'editar_prestamo']);
        Permission::create(['name' => 'eliminar_prestamo']);
        Permission::create(['name' => 'crear_prestamo']);

        Permission::create(['name' => 'ver_autor',]);
        Permission::create(['name' => 'editar_autor']);
        Permission::create(['name' => 'eliminar_autor']);
        Permission::create(['name' => 'crear_autor']);

        Permission::create(['name' => 'ver_usuario',]);
        Permission::create(['name' => 'editar_usuario']);
        Permission::create(['name' => 'eliminar_usuario']);
        Permission::create(['name' => 'crear_usuario']);

        Permission::create(['name' => 'ver_categoria',]);
        Permission::create(['name' => 'editar_categoria']);
        Permission::create(['name' => 'eliminar_categoria']);
        Permission::create(['name' => 'crear_categoria']);
    }
}
