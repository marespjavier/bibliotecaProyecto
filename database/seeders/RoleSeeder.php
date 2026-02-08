<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        // Crear roles
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Bibliotecario']);
        Role::create(['name' => 'Usuario']);

        // ADMIN -> todos los permisos
        $admin = Role::findByName('Admin');
        $admin->givePermissionTo(Permission::all());

        // BIBLIOTECARIO -> gestiona catálogo + préstamos + ver usuarios
        $bibliotecario = Role::findByName('Bibliotecario');
        $bibliotecario->givePermissionTo([
            'ver_libro', 'crear_libro', 'editar_libro', 'eliminar_libro',
            'ver_autor', 'crear_autor', 'editar_autor', 'eliminar_autor',
            'ver_categoria', 'crear_categoria', 'editar_categoria', 'eliminar_categoria',
            'ver_prestamo', 'crear_prestamo', 'editar_prestamo', 'eliminar_prestamo',
            'ver_usuario',
        ]);

        // USUARIO -> solo lectura + ver préstamos (luego limitas a "sus préstamos")
        $usuario = Role::findByName('Usuario');
        $usuario->givePermissionTo([
            'ver_libro',
            'ver_autor',
            'ver_categoria',
            'ver_prestamo',
            'ver_usuario',
        ]);
    }
}
