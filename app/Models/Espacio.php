<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property array $horariosOcupados
 * @property string $nombre
 * @property int $capacidad
 * @property int $localizacion_id
 * @property int $tiposespacios_id
 * @property string $codigo
 * @property TipoEspacio $tipoEspacio
 * @property Localizacion $localizacion
 */
class Espacio extends Model
{
    const TABLA = 'espacios';
    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = [
        'nombre',
        'localizacion_id',
        'tiposespacios_id',
        'capacidad',
    ];

    /**
     * Obtener el tipo de espacio asociado al espacio
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function tipoEspacio()
    {
        return $this->hasOne(TipoEspacio::class, 'id', 'tiposespacios_id');
    }

    /**
     * Obtener la localización asociada al espacio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function localizacion()
    {
        return $this->belongsTo(Localizacion::class);
    }

    /**
     * Obtenemos los equipamientos asociados al espacio
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function equipamientos()
    {
        return EquipamientoEspacio::where('espacio_id', $this->id)->with('equipamiento')->get();
    }

    /**
     * Obtener las reservas asociadas al espacio
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */

    public function reservas()
    {
        return $this->morphMany(Reserva::class, 'reservable');
    }

    /**
     * Horarios ocupados por el espacio
     * Devuelve los horarios que no están disponibles para reservar
     * 
     * @return array
     */

    public function horariosOcupados()
    {
        return $this->reservas->map(function ($reserva) {
            return [
                'fecha' => $reserva->fecha,
                'hora_inicio' => $reserva->hora_inicio,
                'hora_fin' => $reserva->hora_fin,
                'estado' => $reserva->estado(),
                'asignado_a' => $reserva->usuario->name ?? 'No asignado',
            ];
        })->toArray();
    }
}
