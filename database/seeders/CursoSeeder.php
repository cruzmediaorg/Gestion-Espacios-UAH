<?php

namespace Database\Seeders;

use App\Models\Curso;
use App\Models\Grado;
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
                "anio" => 2024,
                "numero" => 1,
                "asignatura_id" => $asignatura->id,
                "docente_id" => User::where("name", "Responsable")->first()->id,
            ]);

            $alumnos = User::where("tipo", "general")->get();

            $curso->alumnos()->attach($alumnos);
        }
    }
}
