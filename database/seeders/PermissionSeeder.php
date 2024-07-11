<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'Crear usuarios',
            'Ver usuarios',
            'Actualizar usuarios',
            'Eliminar usuarios',
            'Crear roles',
            'Ver roles',
            'Actualizar roles',
            'Eliminar roles',
            'Crear espacios',
            'Ver espacios',
            'Editar espacios',
            'Crear grados',
            'Ver grados',
            'Editar grados',
            'Crear asignaturas',
            'Ver asignaturas',
            'Editar asignaturas',
            'Crear cursos',
            'Ver cursos',
            'Editar cursos',
            'Gestionar tareas automatizadas',
            'Ver logs',
            'Generar reservas',
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $role = Role::where('name', 'Administrador')->first();
        $role->syncPermissions(\Spatie\Permission\Models\Permission::all());

        $role = Role::where('name', 'Responsable')->first();

        $role->syncPermissions([
            'Ver cursos',
            'Ver asignaturas',
        ]);
    }
}
