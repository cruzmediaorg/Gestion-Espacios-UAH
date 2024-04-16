<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Spatie\Permission\Models\Role;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Role::create(['name' => 'administrador']);
        Role::create(['name' => 'responsable']);
        Role::create(['name' => 'general']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Role::where('name', 'administrador')->delete();
        Role::where('name', 'responsable')->delete();
        Role::where('name', 'general')->delete();
    }
};
