<?php

namespace Database\Seeders;

use App\Models\Equipamiento;
use App\Models\Espacio;
use App\Models\Localizacion;
use App\Models\TipoEspacio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EspacioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       //
        $array = [
            ["TIPO" => "Laboratorio", "Nombre" => "NL10", "Capacidad" => 20],
            ["TIPO" => "Laboratorio", "Nombre" => "NL11", "Capacidad" => 35],
            ["TIPO" => "Laboratorio", "Nombre" => "NL12", "Capacidad" => 20],
            ["TIPO" => "Laboratorio", "Nombre" => "NL3", "Capacidad" => 20],
            ["TIPO" => "Laboratorio", "Nombre" => "NL4", "Capacidad" => 20],
            ["TIPO" => "Laboratorio", "Nombre" => "NL6", "Capacidad" => 20],
            ["TIPO" => "Laboratorio", "Nombre" => "NL7", "Capacidad" => 20],
            ["TIPO" => "Laboratorio", "Nombre" => "NL8", "Capacidad" => 35],
            ["TIPO" => "Laboratorio", "Nombre" => "NL9", "Capacidad" => 20],
            ["TIPO" => "Laboratorio", "Nombre" => "NL27", "Capacidad" => 20],
            ["TIPO" => "Sala de trabajo", "Nombre" => "SN33", "Capacidad" => 15],
            ["TIPO" => "Sala de trabajo", "Nombre" => "SN22", "Capacidad" => 15],
            ["TIPO" => "Sala de reuniones", "Nombre" => "Sala Común", "Capacidad" => 15],
            ["TIPO" => "Sala de reuniones", "Nombre" => "Sala de Juntas", "Capacidad" => 70],
            ["TIPO" => "Despacho", "Nombre" => "DN311", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN312", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN313", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN314", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN315", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN316", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN317", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN318", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN321", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN322", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN323", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN324", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN325", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN326", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN327", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN328", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN331", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN332", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN333", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN334", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN335", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN336", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN337", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN338", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN341", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN342", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN343", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN344", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN345", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN346", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN347", "Capacidad" => 1],
            ["TIPO" => "Despacho", "Nombre" => "DN348", "Capacidad" => 1]
        ];

        foreach ($array as $espacio) {
            Espacio::create([
                'tiposespacios_id' => TipoEspacio::where('nombre', $espacio['TIPO'])->first()->id,
                'nombre' => $espacio['Nombre'],
                'capacidad' => $espacio['Capacidad'],
                'codigo' => $espacio['Nombre'],
                'localizacion_id' => Localizacion::where('nombre', 'EPS - Norte')->first()->id,
            ]);
        }

    }
}
