<?php

use App\Models\Curso;
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
        Schema::create(Curso::TABLA, function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->bigInteger('anio');
            $table->bigInteger('numero');
            $table->foreignId('asignatura_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('docente_id');
            $table->foreign('docente_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Curso::TABLA);
    }
};
