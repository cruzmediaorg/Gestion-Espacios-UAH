<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('dias');
            $table->dropColumn('hora_inicio');
            $table->dropColumn('hora_fin');
            $table->dropColumn('cantidad_horas');
            $table->dropColumn('total_clases_semana');
            $table->integer('total_clases_curso')->nullable();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cursos', function (Blueprint $table) {
            $table->string('dias');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->integer('cantidad_horas');
            $table->integer('total_clases_semana');
            $table->dropColumn('total_clases_curso');
        });
    }
};
