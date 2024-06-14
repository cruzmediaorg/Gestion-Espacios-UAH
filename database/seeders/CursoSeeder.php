<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Grado;
use App\Models\Periodo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Log;

class CursoSeeder extends Seeder
{

    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $grado = Grado::where(
            "nombre",
            "Máster en Desarrollo Ágil de Software para la Web"
        )
            ->with("asignaturas")
            ->first();



        $docentes = User::where("tipo", "responsable")->get();

        // Se crea un curso por cada asignatura del grado para el año 2024
        foreach ($grado->asignaturas as $asignatura) {
            $curso = Curso::create([
                "nombre" => $asignatura->nombre . " - " . $grado->nombre,
                "periodo_id" => Periodo::where("nombre", "2024-2025")->first()->id,
                "asignatura_id" => $asignatura->id,
                "dias" => "V",
                "hora_inicio" => "16:00:00",
                "hora_fin" => "21:00:00",
                "cantidad_horas" => 10,
                "alumnos_matriculados" => rand(20, 50),
            ]);

            // Seleccionar aleatoriamente 1 o 2 docentes
            $numDocentes = rand(1, 2);
            $docentesSeleccionados = $docentes->random($numDocentes);

            // Asignar los docentes al curso
            $curso->docentes()->attach($docentesSeleccionados);
        }
    }
}
