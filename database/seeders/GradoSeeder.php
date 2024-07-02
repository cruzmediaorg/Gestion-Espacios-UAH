<?php

namespace Database\Seeders;

use App\Models\Grado;
use App\Models\TipoGrado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradoSeeder extends Seeder
{


    const GRADOS = [
        'Ingeniería Informática',
        'Ingeniería de Computadores',
        'Ingeniería en Sistemas de Información',
    ];

    const MASTERS = [
        'Desarrollo Ágil del SW para la Web',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::GRADOS as $grado) {
            Grado::create(['nombre' => 'Grado en ' . $grado, 'tipoGrado_id' => TipoGrado::where('nombre', 'Grado Superior')->first()->id, 'codigo' => $this->generarCodigo('GR')]);
        }

        foreach (self::MASTERS as $master) {
            Grado::create(['nombre' => 'Máster en ' . $master, 'tipoGrado_id' => TipoGrado::where('nombre', 'Máster')->first()->id, 'codigo' => $this->generarCodigo('MA')]);
        }
    }

    /**
     * Genera un código aleatorio con el prefijo 'UAH-PREFIJO'
     */
    private function generarCodigo(string $prefijo): string
    {

        $code = 'UAH-' . $prefijo;
        $code .= '-' . random_int(1000, 9999);

        return $code;
    }
}
