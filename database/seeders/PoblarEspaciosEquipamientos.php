<?php

namespace Database\Seeders;

use App\Models\Equipamiento;
use App\Models\Espacio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PoblarEspaciosEquipamientos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Luego de crear los espacios, creamos las relaciones con equipamientos
        // Recorremos todos los espacios
        // Los espacios tipoEspacio 'Laboratorio':
        // Tendran 'Puestos con ordenador' (La misma cantidad de puestos que capacidad)
        // Tendran 'Pizarra' (1)
        // Tendran 'Proyector' (1)
        // Los espacios tipoEspacio 'Aula':
        // Tendran 'Pizarra' (1)
        // Tendran 'Proyector' (1)
        // Tendran 'Puestos sin ordenador' (La misma cantidad de puestos que capacidad)

        $espacios = Espacio::all();
        foreach ($espacios as $espacio) {
            $equipamientos = Equipamiento::all();
            foreach ($equipamientos as $equipamiento) {
                if ($espacio->tipoEspacio->nombre == 'Laboratorio') {
                    if ($equipamiento->nombre == 'Puestos con ordenador') {
                        $espacio->equipamientos()->attach($equipamiento, ['cantidad' => $espacio->capacidad]);
                    } else if ($equipamiento->nombre == 'Pizarra' || $equipamiento->nombre == 'Proyector') {
                        $espacio->equipamientos()->attach($equipamiento, ['cantidad' => 1]);
                    }
                } else if ($espacio->tipoEspacio->nombre == 'Aula') {
                    if ($equipamiento->nombre == 'Puestos sin ordenador') {
                        $espacio->equipamientos()->attach($equipamiento, ['cantidad' => $espacio->capacidad]);
                    } else if ($equipamiento->nombre == 'Pizarra' || $equipamiento->nombre == 'Proyector') {
                        $espacio->equipamientos()->attach($equipamiento, ['cantidad' => 1]);
                    }
                }
            }
        }
    }
}
