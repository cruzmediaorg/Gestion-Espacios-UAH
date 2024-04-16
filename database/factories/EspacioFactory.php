<?php

namespace Database\Factories;

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

        return [
            'nombre' => "{$tipoEspacio->nombre} - {$this->faker->unique()->numberBetween(1, 100)} - {$localizacion->nombre}",
            'localizacion_id' => $localizacion->id,
            'tiposespacios_id' => $tipoEspacio->id,
            'capacidad' => $this->faker->numberBetween(20, 30),
        ];
    }
}
