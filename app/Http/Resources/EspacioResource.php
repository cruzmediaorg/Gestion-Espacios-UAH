<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;


/**
 * @mixin \App\Models\Espacio
 */
class EspacioResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'tipo' => $this->tipoEspacio,
            'localizacion' => $this->localizacion,
            'capacidad' => $this->capacidad,
            'horarios_ocupados' => $this->horariosOcupados(),
            'equipamientos' => $this->equipamientos(),
        ];
    }
}
