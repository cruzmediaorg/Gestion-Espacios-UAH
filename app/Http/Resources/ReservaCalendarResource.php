<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin \App\Models\Reserva */
class ReservaCalendarResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'Id' => $this->id,
            'Subject' => $this->usuario->name . ' - ' . $this->type,
            'Description' => $this->comentario,
            'StartTime' => $this->fecha . 'T' . $this->hora_inicio . '.000Z',
            'EndTime' => $this->fecha . 'T' . $this->hora_fin . '.000Z',
            'RoomId' => $this->reservable->id,
        ];
    }
}
