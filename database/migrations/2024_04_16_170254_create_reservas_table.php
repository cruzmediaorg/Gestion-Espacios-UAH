<?php


use App\Models\Reserva;
use App\ReservaType;
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
            $table->unsignedBigInteger('reservable_id');
            $table->string('reservable_type');
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
            $table->enum('type', [ReservaType::ClasePractica->value, ReservaType::ClaseTeorica->value, ReservaType::TFGTFM->value, ReservaType::Examen->value, ReservaType::Conferencia->value, ReservaType::Reunion->value, ReservaType::ConsejoDpt->value, ReservaType::Otro->value])->default(ReservaType::Otro->value);
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
