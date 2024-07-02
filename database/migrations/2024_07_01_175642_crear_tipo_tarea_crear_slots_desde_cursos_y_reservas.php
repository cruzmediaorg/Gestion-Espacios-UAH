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
            'alias' => 'crear_reservas_sin_slots',
        ], [
            'nombre' => 'Crear reservas desde Cursos, Generando slots',
            'descripcion' => 'Crea reservas desde cursos, generando slots',
            'clasePHP' => 'CrearReservasDesdeCursosGenerandoSlotsJob',
            'periocidad' => 'DESACTIVADA',
            'parametros_requeridos' => [
                [
                    "key" => "cursos",
                    "label" => "Cursos",
                    "descripcion" => "Inserta los IDs de los cursos separados por comas, por ejemplo: 1,2,3. Si desea generar para todos, escribe 'TODOS', se tomarán todos los cursos que tengan slots sin reservas.",
                ]
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        TipoTarea::where('alias', 'crear_reservas_sin_slots')->forceDelete();
    }
};
