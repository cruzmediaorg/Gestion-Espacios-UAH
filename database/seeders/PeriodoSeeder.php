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
        Periodo::updateOrcreate(
            ['nombre' => '2023-2024 C1'], ['fecha_inicio' => '2023-09-01', 'fecha_fin' => '2023-12-31']
        );

        Periodo::updateOrcreate(
            ['nombre' => '2023-2024 C2'], ['fecha_inicio' => '2024-01-01', 'fecha_fin' => '2024-12-31']
        );

        Periodo::updateOrcreate(
            ['nombre' => '2024-2025 C1'],['fecha_inicio' => '2024-09-09', 'fecha_fin' => '2024-12-20']
        );

        Periodo::updateOrcreate(
            ['nombre' => '2024-2025 C2'],[ 'fecha_inicio' => '2025-01-23', 'fecha_fin' => '2025-05-14']
        );

    }
}
