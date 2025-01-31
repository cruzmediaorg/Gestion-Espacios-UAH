<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Espacio */
class EspacioCalendarResource extends JsonResource
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
            'text' => $this->codigo,
            'color' => '#' . $this->tipoEspacio->color,
            'capacity' => $this->capacidad,
            'type' => $this->tipoEspacio->nombre,
        ];
    }
}
