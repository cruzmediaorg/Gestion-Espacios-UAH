<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoblarEspaciosCaracteristicas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Cada espacio tiene las siguientes características:
        // Laboratorio. Son espacios para docencia.
        // Sala común. Permiten reservas puntuales o permanentes de los profesores. No permite más de 1 reserva simultánea.
        // Despacho. Se asigna a uno o varios profesores. 

        // Recorrer todos los tiposEspacios
        // Si tipoEspacio->nombre == 'Laboratorio' -> tipoEspacio->caracteristicas()->attach('Laboratorio')

        $tipoEspacio = \App\Models\TipoEspacio::all();

        foreach ($tipoEspacio as $tipo) {
            if ($tipo->nombre == 'Laboratorio') {
                $tipo->caracteristicas()->attach(\App\Models\Caracteristica::where('nombre', 'Laboratorio')->first());
            } else if ($tipo->nombre == 'Sala de reuniones') {
                $tipo->caracteristicas()->attach(\App\Models\Caracteristica::where('nombre', 'Sala común')->first());
            } else if ($tipo->nombre == 'Despacho') {
                $tipo->caracteristicas()->attach(\App\Models\Caracteristica::where('nombre', 'Despacho')->first());
            }
        }
    }
}
