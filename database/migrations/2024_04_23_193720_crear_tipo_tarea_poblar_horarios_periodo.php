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
        TipoTarea::create([
            'nombre' => 'Poblar horarios periodo',
            'alias' => 'poblar_horarios_periodo',
            'descripcion' => 'Pobla los horarios de un curso en un periodo especificado',
            'clasePHP' => 'PoblaHorariosPeriodo',
            'periocidad' => 'DESACTIVADA',
            'parametros_requeridos' => [
                [
                    "key" => "periodo",
                    "label" => "Periodo",
                    "descripcion" => "Inserta el periodo para crear los horarios. El periodo debe estar en formato AAAA-AAAA (Ej. 2023-2024)",
                    "regex" => "\\d+-\\d+"
                ]
            ]
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        TipoTarea::where('alias', 'poblar_horarios_periodo')->forceDelete();
    }
};
