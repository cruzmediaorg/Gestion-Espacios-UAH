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
        // Drop foreign docente_id from cursos
        Schema::table('cursos', function (Blueprint $table) {
            $table->dropForeign(['docente_id']);
            $table->dropColumn('docente_id');
        });

        // // Crea la tabla pivot
        Schema::create('curso_docente', function (Blueprint $table) {
            $table->id();
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->unsignedBigInteger('docente_id');
            $table->foreign('docente_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop pivot table
        Schema::dropIfExists('curso_docente');

        // Add foreign docente_id to cursos
        Schema::table('cursos', function (Blueprint $table) {
            $table->foreign('docente_id')->references('id')->on('users')->onDelete('cascade');
        });
    }
};
