<?php

use App\Models\Grado;
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
        Schema::create(Grado::TABLA, function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('tipoGrado_id');
            $table->foreign('tipoGrado_id')->references('id')->on('tiposGrados')->cascadeOnDelete();
            $table->string('codigo');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Grado::TABLA);
    }
};
