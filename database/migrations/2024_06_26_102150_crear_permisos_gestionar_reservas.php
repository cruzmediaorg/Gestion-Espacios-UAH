<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        $permisos = [
            'Gestionar reservas',
            'Aprobar reservas',
            'Rechazar reservas',
            'Ver reservas',
        ];


        foreach ($permisos as $permiso) {
            Permission::create(['name' => $permiso]);
        }

        $role = Role::where('name', 'Administrador')->first();

        foreach ($permisos as $permiso) {
            $role->givePermissionTo($permiso);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permisos = [
            'Gestionar reservas',
            'Aprobar reservas',
            'Rechazar reservas',
            'Ver reservas',
        ];

        foreach ($permisos as $permiso) {
            Permission::where('name', $permiso)->delete();
        }

        $role = Role::where('name', 'Administrador')->first();

        foreach ($permisos as $permiso) {
            $role->revokePermissionTo($permiso);
        }

    }
};
