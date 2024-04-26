<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Grado;
use App\Models\Periodo;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

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

        // Se crea un curso por cada asignatura del grado para el año 2024
        foreach ($grado->asignaturas as $asignatura) {
            $curso = Curso::create([
                "nombre" => $asignatura->nombre . " - " . $grado->nombre,
                "periodo_id" => Periodo::where("nombre", "2024-2025")->first()->id,
                "asignatura_id" => $asignatura->id,
                "docente_id" => User::where("name", "Responsable")->first()->id,
                "dias" => "V",
                "hora_inicio" => "16:00:00",
                "hora_fin" => "21:00:00",
                "cantidad_horas" => 10
            ]);

            $alumnos = User::where("tipo", "general")->get();

            $curso->alumnos()->attach($alumnos);
        }
    }
}
