<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;
use Database\Seeders\TipoGradoSeeder;
use Database\Seeders\GradoSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TipoGradoSeeder::class,
            GradoSeeder::class,
            AsignaturaSeeder::class,
            UserAlumnoDocenteSeeder::class,
            UsuariosRandomSeeder::class,
            PeriodoSeeder::class,
            CursoSeeder::class,
            HorarioSeeder::class,
            LocalizacionesTipoEquipamientoEspaciosSeeder::class,
            EspacioSeeder::class,
            PoblarEspaciosEquipamientos::class,
            CaracteristicaSeeder::class,
            PoblarEspaciosCaracteristicas::class,
            PermissionSeeder::class,
        ]);
    }
}
