<?php

use App\Models\Espacio;
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
        Schema::create(Espacio::TABLA, function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->unsignedBigInteger('localizacion_id');
            $table->foreign('localizacion_id')->references('id')->on('localizaciones')->cascadeOnDelete();
            $table->foreignId('tiposespacios_id')->constrained()->cascadeOnDelete();
            $table->bigInteger('capacidad');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Espacio::TABLA);
    }
};
