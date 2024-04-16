<?php

namespace Database\Seeders;

use App\Models\Curso;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HorarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $cursos = \App\Models\Curso::all();

        $inicioPeriodo = Carbon::createFromDate(2023, 9, 1);
        $finPeriodo = Carbon::createFromDate(2023, 12, 14);

        $vacaciones = [
            ['inicio' => Carbon::createFromDate(2023, 12, 15), 'fin' => Carbon::createFromDate(2024, 1, 15)],
            ['inicio' => Carbon::createFromDate(2024, 3, 28), 'fin' => Carbon::createFromDate(2024, 4, 15)]
        ];

        $cursos = Curso::all();
        $fechaActual = $inicioPeriodo->copy();

        // Encontrar todos los viernes en el rango de fechas, excluyendo vacaciones
        $viernesDisponibles = [];
        while ($fechaActual <= $finPeriodo) {
            if ($fechaActual->isFriday() && !$this->esVacaciones($fechaActual, $vacaciones)) {
                array_push($viernesDisponibles, $fechaActual->copy());
            }
            $fechaActual->addDay();
        }

        // Asignar fechas a cursos
        $index = 0;
        foreach ($cursos as $curso) {
            if (isset($viernesDisponibles[$index]) && isset($viernesDisponibles[$index + 1])) {
                $curso->horarios()->create([
                    'fecha' => $viernesDisponibles[$index],
                    'hora_inicio' => '16:00',
                    'hora_fin' => '21:00'
                ]);
                $curso->horarios()->create([
                    'fecha' => $viernesDisponibles[$index + 1],
                    'hora_inicio' => '16:00',
                    'hora_fin' => '21:00'
                ]);
                $index += 2;
            }
        }
    }

    private function esVacaciones(Carbon $date, array $vacations)
    {
        foreach ($vacations as $vacation) {
            if ($date->between($vacation['inicio'], $vacation['fin'])) {
                return true;
            }
        }
        return false;
    }
}
