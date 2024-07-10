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
            'ReservaId' => $this->id,
            'Id' => $this->id,
            'Subject' => '#' . $this->id . ' ' .  $this->usuario->name . ' - ' . $this->curso,
            'Description' => $this->comentario,
            'Dia' => $this->fecha,
            'HoraInicio' => $this->hora_inicio,
            'HoraFin' => $this->hora_fin,
            'StartTime' => $this->fecha . 'T' . $this->hora_inicio . '.000Z',
            'EndTime' => $this->fecha . 'T' . $this->hora_fin . '.000Z',
            'RoomId' => $this->reservable->id,
            'Status' => $this->estado(),
            'User' => $this->usuario->name,
            'Espacio' => $this->reservable->nombreConLocalizacion . ' - (' . $this->reservable->tipoEspacioName . ')',
            'Comentario' => $this->comentario,
            'SePuedeEditar' => $this->estado !== 'cerrada' && $this->estado !== 'cancelada',
        ];
    }
}
