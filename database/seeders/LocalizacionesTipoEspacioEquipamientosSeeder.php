<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LocalizacionesTipoEspacioEquipamientosSeeder extends Seeder
{

    const ZONAS = [
        'Edificio Politécnico - Zona Norte',
        'Edificio Politécnico - Zona Sur',
        'Edificio Politécnico - Zona Este',
        'Edificio Politécnico - Zona Oeste',
    ];

    const TIPOS = [
        'Aula',
        'Laboratorio',
        'Biblioteca',
        'Auditorio',
        'Sala de reuniones'
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
                'nombre' => $tipo
            ]);
        }

        foreach (self::EQUIPAMIENTOS as $equipamiento) {
            \App\Models\Equipamiento::create([
                'nombre' => $equipamiento
            ]);
        }
    }
}
