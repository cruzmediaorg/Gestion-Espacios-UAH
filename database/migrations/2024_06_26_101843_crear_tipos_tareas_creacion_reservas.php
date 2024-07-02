<?php

use App\Models\TipoTarea;
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
        TipoTarea::updateOrCreate([
            'alias' => 'crear_reservas_slots',
        ], [
            'nombre' => 'Crear reservas desde Slots',
            'descripcion' => 'Crea reservas desde slots',
            'clasePHP' => 'CrearReservasDesdeSlotsJob',
            'periocidad' => 'DESACTIVADA',
        ]);

        TipoTarea::updateOrCreate([
            'alias' => 'aceptar_reservas_sin_conflictos',
        ], [
            'nombre' => 'Aceptar reservas sin conflictos',
            'descripcion' => 'Acepta las reservas sin conflictos automáticamente',
            'clasePHP' => 'AceptarReservasSinConflictosJob.php',
            'periocidad' => 'DESACTIVADA',
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        TipoTarea::where('alias', 'crear_reservas_slots')->forceDelete();
        TipoTarea::where('alias', 'aceptar_reservas_sin_conflictos')->forceDelete();
    }
};
