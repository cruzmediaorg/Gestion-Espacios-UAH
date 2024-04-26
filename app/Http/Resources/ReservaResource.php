<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin \App\Models\Reserva
 */
class ReservaResource extends JsonResource
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
            'reservable' => $this->reservable,
            'type' => class_basename($this->reservable),
            'reservable_id' => $this->reservable_id,
            'reservable_type' => $this->reservable_type,
            'asignado_a' => $this->usuario,
            'fecha' => $this->fecha,
            'hora_inicio' => $this->hora_inicio,
            'hora_fin' => $this->hora_fin,
            'comentario' => $this->comentario,
            'estado' => $this->estado(),
            'fecha_aprobacion' => $this->fecha_aprobacion,
            'fecha_rechazo' => $this->fecha_rechazo,
            'fecha_cancelacion' => $this->fecha_cancelacion,
            'cancelado_por' => $this->cancelado_por,
            'horas' => $this->hora_inicio . ' - ' . $this->hora_fin,
            'tipo_reserva' => $this->type,
        ];
    }
}
