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
        Schema::create(AlumnoCurso::TABLA, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('alumno_id');
            $table->foreign('alumno_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('curso_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(AlumnoCurso::TABLA);
    }
};
