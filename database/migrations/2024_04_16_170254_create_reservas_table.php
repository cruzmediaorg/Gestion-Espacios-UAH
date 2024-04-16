<?php

use App\Estado;
use App\Estados;
use App\Models\Reserva;
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
        Schema::create(Reserva::TABLA, function (Blueprint $table) {
            $table->id();
            $table->foreignId('espacio_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('asignado_a');
            $table->foreign('asignado_a')->references('id')->on('users')->cascadeOnDelete();
            $table->date('fecha');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->string('comentario')->nullable();
            $table->dateTime('fecha_aprobacion')->nullable();
            $table->dateTime('fecha_rechazo')->nullable();
            $table->dateTime('fecha_cancelacion')->nullable();
            $table->unsignedBigInteger('cancelado_por')->nullable();
            $table->foreign('cancelado_por')->references('id')->on('users')->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Reserva::TABLA);
    }
};
