<?php

namespace Database\Seeders;

use App\Models\Equipamiento;
use App\Models\Espacio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Espacio::factory()->count(50)->create();
    }
}
