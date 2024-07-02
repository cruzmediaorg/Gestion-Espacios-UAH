<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalizacionesTipoEquipamientoEspaciosSeeder extends Seeder
{

    const ZONAS = [
        'EPS - Norte',
        'EPS- Oeste',
    ];

    const TIPOS = [
        'Aula',
        'Laboratorio',
        'Sala de reuniones',
        'Despacho',
        'Sala de trabajo',
    ];

    const EQUIPAMIENTOS = [
        'Proyector',
        'Pizarra',
        'Pizarra digital',
        'Ordenador',
        'Sillas',
        'Mesas',
        'Armarios',
        'Estanterías',
        'Pantalla',
        'Puestos con ordenador',
        'Puestos sin ordenador',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::ZONAS as $zona) {
            \App\Models\Localizacion::create([
                'nombre' => $zona
            ]);
        }

        foreach (self::TIPOS as $tipo) {
            \App\Models\TipoEspacio::create([
                'nombre' => $tipo,
                'color' => $this->randomColor()
            ]);
        }

        foreach (self::EQUIPAMIENTOS as $equipamiento) {
            \App\Models\Equipamiento::create([
                'nombre' => $equipamiento
            ]);
        }
    }

    /**
     * Generador de colores aleatorios
     * @return string
     */
    private function randomColor(): string
    {
        return sprintf('%06X', mt_rand(0, 0xFFFFFF));
    }
}
