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
        TipoTarea::create(['nombre' => 'Carga CSV Asignaturas', 'alias' => 'carga_csv_asignaturas', 'descripcion' => 'Carga de asignaturas desde un archivo CSV', 'clasePHP' => 'CargaCSVAsignaturas', 'periocidad' => 'DESACTIVADA']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        TipoTarea::where('alias', 'carga_csv_asignaturas')->forceDelete();
    }
};
