<?php

namespace Database\Seeders;

use App\Models\Periodo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeriodoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Periodo::create(
            ['nombre' => '2023-2024', 'fecha_inicio' => '2023-09-01', 'fecha_fin' => '2024-06-30']
        );

        Periodo::create(
            ['nombre' => '2024-2025', 'fecha_inicio' => '2024-09-01', 'fecha_fin' => '2025-06-30']
        );
    }
}
