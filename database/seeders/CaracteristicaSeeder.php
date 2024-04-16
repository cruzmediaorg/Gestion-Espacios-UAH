<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CaracteristicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Cada espacio tiene las siguientes características:
        // Laboratorio. Son espacios para docencia.
        // Sala común. Permiten reservas puntuales o permanentes de los profesores. No permite más de 1 reserva simultánea.
        // Despacho. Se asigna a uno o varios profesores. 

        $caracteristicas = [
            [
                "nombre" => "Laboratorio",
                "descripcion" => "Son espacios para docencia."
            ],
            [
                "nombre" => "Sala común",
                "descripcion" => "Permiten reservas puntuales o permanentes de los profesores. No permite más de 1 reserva simultánea."
            ],
            [
                "nombre" => "Despacho",
                "descripcion" => "Se asigna a uno o varios profesores."
            ]
        ];

        foreach ($caracteristicas as $caracteristica) {
            \App\Models\Caracteristica::create([
                "nombre" => $caracteristica["nombre"],
                "descripcion" => $caracteristica["descripcion"]
            ]);
        }
    }
}
