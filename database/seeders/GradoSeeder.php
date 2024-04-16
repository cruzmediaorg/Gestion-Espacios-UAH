<?php

namespace Database\Seeders;

use App\Models\Grado;
use App\Models\TipoGrado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GradoSeeder extends Seeder
{


    const GRADOS = [
        'Humanidades y Magisterio en Educación Primaria',
        'Estudios Hispánicos',
        'Estudios Ingleses',
        'Historia',
        'Humanidades',
        'Lenguas Modernas y Traducción',
        'Lenguas Modernas y Traducción.',
        'Ciencias de la Actividad Física y del Deporte',
        'Enfermería',
        'Fisioterapia',
        'Medicina',
        'Farmacia',
        'Biología Sanitaria',
        'Psicología',
        'Logopedia',
        'Nutrición Humana y Dietética',
        'Optica y Optometría',
        'Arquitectura Técnica y Edificación',
        'Fundamentos de Arquitectura y Urbanismo',
        'Ingeniería Electrónica de Comunicaciones e Ingeniería Electrónica y Automática Industrial',
        'Ingeniería Electrónica de Comunicaciones',
        'Ingeniería Informática',
        'Ingeniería Telemática',
        'Ingeniería de Computadores',
        'Ingeniería en Electrónica y Automática Industrial',
        'Ingeniería en Sistemas de Información',
        'Ingeniería en Sistemas de Telecomunicación',
        'Ingeniería en Tecnologías Industriales',
        'Ingeniería en Tecnologías de Telecomunicación',
        'Matemáticas y Computación',
        'Ingeniería Informática y Administración y Dirección de Empresas',
        'Comunicación Audiovisual',
        'Humanidades y Magisterio en Educación Primaria',
        'Magisterio de Educación Infantil',
        'Magisterio de Educación Primaria',
        'Derecho',
        'Derecho y Administración y Dirección de Empresas',
        'Turismo y Administración y Dirección de Empresas',
        'Administración y Dirección de Empresas',
        'Economía',
        'Economía y Negocios Internacionales',
        'Finanzas',
        'Biología',
        'Ciencias Ambientales',
        'Criminalística: Ciencias y Tecnologías Forenses',
        'Física e Instrumentación Espacial',
        'Quimica',
    ];

    const MASTERS = [
        'Desarrollo Ágil de Software para la Web',
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
