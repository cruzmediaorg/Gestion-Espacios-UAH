<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Contracts\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role as ModelsRole;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $permiso = Permission::where('name', 'Ver espacios')->first();

        $role = ModelsRole::where('name', 'Responsable')->first();

        if ($permiso && $role) {
            $role->givePermissionTo($permiso);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $permiso = Permission::where('name', 'Ver espacios')->first();

        $role = ModelsRole::where('name', 'Responsable')->first();

        if ($permiso && $role) {
            $role->revokePermissionTo($permiso);
        }
    }
};
