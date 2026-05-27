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
        Permission::firstOrCreate(['name' => 'ver_libro',]);
        Permission::firstOrCreate(['name' => 'editar_libro']);
        Permission::firstOrCreate(['name' => 'eliminar_libro']);
        Permission::firstOrCreate(['name' => 'crear_libro']);

        Permission::firstOrCreate(['name' => 'ver_prestamo',]);
        Permission::firstOrCreate(['name' => 'editar_prestamo']);
        Permission::firstOrCreate(['name' => 'eliminar_prestamo']);
        Permission::firstOrCreate(['name' => 'crear_prestamo']);

        Permission::firstOrCreate(['name' => 'ver_autor',]);
        Permission::firstOrCreate(['name' => 'editar_autor']);
        Permission::firstOrCreate(['name' => 'eliminar_autor']);
        Permission::firstOrCreate(['name' => 'crear_autor']);

        Permission::firstOrCreate(['name' => 'ver_usuario',]);
        Permission::firstOrCreate(['name' => 'editar_usuario']);
        Permission::firstOrCreate(['name' => 'eliminar_usuario']);
        Permission::firstOrCreate(['name' => 'crear_usuario']);

        Permission::firstOrCreate(['name' => 'ver_categoria',]);
        Permission::firstOrCreate(['name' => 'editar_categoria']);
        Permission::firstOrCreate(['name' => 'eliminar_categoria']);
        Permission::firstOrCreate(['name' => 'crear_categoria']);
    }
}
