<?php

use App\Models\AlumnoCurso;
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
        // Borramos la tabla alumno_curso
        Schema::dropIfExists('alumno_curso');

        // Añadimos la columna "alumnos_matriculados" a la tabla "cursos"
        Schema::table('cursos', function (Blueprint $table) {
            $table->integer('alumnos_matriculados')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Añadimos la tabla "alumno_curso"
        Schema::create('alumno_curso', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });

        // Eliminamos la columna "alumnos_matriculados" de la tabla "cursos"
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropColumn('alumnos_matriculados');
        });
    }
};
