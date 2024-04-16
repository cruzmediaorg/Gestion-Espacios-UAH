<?php

namespace Database\Seeders;

use App\Models\Asignatura;
use App\Models\AsignaturaGrado;
use App\Models\Grado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AsignaturaSeeder extends Seeder
{

    const ASIGNATURAS = [
        'CLOUD COMPUTING Y CONTENEDORES',
        'DISEÑO SEGURO DE APLICACIONES',
        'EXPERIENCIA DE USUARIO (UX) Y DISEÑO RESPONSIVO',
        'FRAMEWORKS BACKEND Y MICROSERVICIOS',
        'FRAMEWORKS FRONTEND',
        'INTEGRACIÓN CONTINUA EN EL DESARROLLO ÁGIL',
        'METODOLOGÍAS ÁGILES PARA EL DESARROLLO DE SOFTWARE',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::ASIGNATURAS as $asignatura) {
            \App\Models\Asignatura::create(['nombre' => $asignatura, 'codigo' => $this->generarCodigo('DAS')]);

            AsignaturaGrado::create([
                'asignatura_id' => Asignatura::where('nombre', $asignatura)->first()->id,
                'grado_id' => Grado::where('nombre', 'Máster en Desarrollo Ágil de Software para la Web')->first()->id
            ]);
        }
    }

    /**
     * Genera un código aleatorio con el prefijo 'ASIG-PREFIJO'
     */
    private function generarCodigo(string $prefijo): string
    {
        $code = 'ASIG-' . $prefijo;
        $code .= '-' . random_int(1000, 9999);

        return $code;
    }
}
