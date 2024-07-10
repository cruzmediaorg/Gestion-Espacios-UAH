<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
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
        'codigo',
    ];

    protected $appends = ['nombreConLocalizacion', 'tipoEspacioName', 'equipamientos'];

    /**
     * Obtener el tipo de espacio asociado al espacio
     * @return HasOne
     */
    public function tipoEspacio(): HasOne
    {
        return $this->hasOne(TipoEspacio::class, 'id', 'tiposespacios_id');
    }

    /**
     * Obtener la localización asociada al espacio
     * @return BelongsTo
     */
    public function localizacion(): BelongsTo
    {
        return $this->belongsTo(Localizacion::class);
    }

    /**
     * Obtenemos los equipamientos asociados al espacio
     * @return Collection
     */
    public function equipamientos(): Collection
    {
        return EquipamientoEspacio::where('espacio_id', $this->id)->with('equipamiento')->get();
    }

    /**
     * Obtener las reservas asociadas al espacio
     * @return MorphMany
     */

    public function reservas(): MorphMany
    {
        return $this->morphMany(Reserva::class, 'reservable');
    }
    /**
     * @return MorphToMany<Reserva>|MorphMany<Reserva>
     */
    public function reservasActivas()
    {
        return $this->reservas()
            ->where('fecha', '>=', now()->format('Y-m-d'))
            ->whereNull('deleted_at')
            ->whereNull('fecha_rechazo')
            ->whereNull('fecha_cancelacion');
    }

    /**
     * Horarios ocupados por el espacio
     * Devuelve los horarios que no están disponibles para reservar
     * @return array
     */
    public function horariosOcupados(): array
    {
        return $this->reservasActivas->map(function ($reserva) {
            return [
                'fecha' => $reserva->fecha,
                'hora_inicio' => $reserva->hora_inicio,
                'hora_fin' => $reserva->hora_fin,
                'estado' => $reserva->estado(),
                'asignado_a' => $reserva->usuario->name ?? 'No asignado',
            ];
        })->toArray();
    }

    public function disponibilidad(array $slots): array
    {
        $disponibilidad = [];


        foreach ($slots as $slot) {
            $fecha = $slot['fecha'];
            $hora_inicio = $slot['hora_inicio'];
            $hora_fin = $slot['hora_fin'];

            $fecha = new \DateTime($fecha);
            $fecha = $fecha->format('Y-m-d');

            $reservas = $this->reservasActivas->filter(function ($reserva) use ($fecha, $hora_inicio, $hora_fin) {
                return $reserva->fecha == $fecha && $reserva->hora_inicio == $hora_inicio && $reserva->hora_fin == $hora_fin;
            });

            $disponibilidad[] = [
                'fecha' => $fecha,
                'hora_inicio' => $hora_inicio,
                'hora_fin' => $hora_fin,
                'disponible' => $reservas->isEmpty(),
            ];
        }

        return $disponibilidad;
    }

    public function getNombreConLocalizacionAttribute(): string
    {
       $localizacion = $this->localizacion()->first()->nombre;

       return $this->nombre . ' - ' . $localizacion;
    }

    public function getTipoEspacioNameAttribute($value): string
    {
        return $this->tipoEspacio->nombre;
    }

    public function getEquipamientosAttribute($value): Collection
    {
        return $this->equipamientos();
    }
    


}
