<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoGradoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tiposGrados = [
            ['nombre' => 'Doctorado'],
            ['nombre' => 'Máster'],
            ['nombre' => 'Grado Superior'],
            ['nombre' => 'Grado Medio'],
            ['nombre' => 'Grado Básico'],
        ];

        foreach ($tiposGrados as $tipoGrado) {
            \App\Models\TipoGrado::create($tipoGrado);
        }
    }
}
