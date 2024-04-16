<?php

use App\Models\AsignaturaGrado;
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
        Schema::create(AsignaturaGrado::TABLA, function (Blueprint $table) {
            $table->id();
            $table->foreignId('asignatura_id')->constrained()->onDelete('cascade');
            $table->foreignId('grado_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asignatura_grados');
    }
};
