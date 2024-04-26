<?php

namespace Database\Factories;

use App\Models\Espacio;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Localizacion;
use App\Models\TipoEspacio;

class EspacioFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $localizacion = Localizacion::inRandomOrder()->first();
        $tipoEspacio = TipoEspacio::inRandomOrder()->first();
        $codigo = $this->generarCodigo($localizacion, $tipoEspacio);

        return [
            'nombre' => $tipoEspacio->nombre . ' ' . $localizacion->nombre . ' ' . $codigo,
            'localizacion_id' => $localizacion->id,
            'tiposespacios_id' => $tipoEspacio->id,
            'capacidad' => $this->faker->numberBetween(20, 30),
            'codigo' => $codigo,
        ];
    }

    /**
     * Generar un código único para el espacio
     */

    private function generarCodigo($localizacion, $tipoEspacio)
    {


        switch ($localizacion->nombre) {
            case 'Edificio Politécnico - Zona Norte':
                $codigo = 'N';
                break;
            case 'Edificio Politécnico - Zona Sur':
                $codigo = 'S';
                break;
            case 'Edificio Politécnico - Zona Este':
                $codigo = 'E';
                break;
            case 'Edificio Politécnico - Zona Oeste':
                $codigo = 'O';
                break;
        }

        switch ($tipoEspacio->nombre) {
            case 'Aula':
                $codigo .= 'A';
                break;
            case 'Laboratorio':
                $codigo .= 'L';
                break;
            case 'Biblioteca':
                $codigo .= 'B';
                break;
            case 'Auditorio':
                $codigo .= 'U';
                break;
            case 'Sala de reuniones':
                $codigo .= 'R';
                break;
        }

        $codigo .= $this->faker->unique()->numberBetween(1, 50000000);


        return $codigo;
    }
}
