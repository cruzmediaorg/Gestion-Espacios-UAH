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
        ];

        foreach ($permissions as $permission) {
            \Spatie\Permission\Models\Permission::create(['name' => $permission]);
        }

        $role = Role::where('name', 'Administrador')->first();
        $role->syncPermissions(\Spatie\Permission\Models\Permission::all());
    }
}
