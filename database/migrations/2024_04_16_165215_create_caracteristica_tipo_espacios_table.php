<?php

use App\Models\CaracteristicaTipoEspacio;
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
        Schema::create(CaracteristicaTipoEspacio::TABLA, function (Blueprint $table) {
            $table->id();
            $table->foreignId('caracteristica_id')->constrained()->cascadeOnDelete();
            $table->foreignId('tiposespacios_id')->constrained()->cascadeOnDelete();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('caracteristica_tipo_espacios');
    }
};
