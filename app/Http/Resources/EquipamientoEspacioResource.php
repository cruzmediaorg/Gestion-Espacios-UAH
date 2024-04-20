<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EquipamientoEspacioResource extends JsonResource
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
            'espacio_id' => $this->espacio_id,
            'equipamiento_id' => $this->equipamiento_id,
            'cantidad' => $this->cantidad,
            'equipamiento' => $this->equipamiento,
            'espacio' => $this->espacio,
        ];
    }
}
