<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon;
use Log;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

/**
 * @property Carbon $fecha_cancelacion
 * @property Carbon $fecha_aprobacion
 * @property Carbon $fecha_rechazo
 * @property Carbon $fecha
 * @property string $hora_inicio
 * @property string $hora_fin
 * @property string $comentario
 * @property int $cancelado_por
 * @property int $asignado_a
 * @property int $reservable_id
 * @property string $reservable_type
 * @property User $usuario
 * @property string $type
 * @property int $curso_id
 */
class Reserva extends Model
{
    const TABLA = 'reservas';
    const ROUTE_PREFIX = 'reservas';

    use  SoftDeletes, LogsActivity;

    protected $fillable = [
        'reservable_id',
        'reservable_type',
        'asignado_a',
        'fecha',
        'hora_inicio',
        'hora_fin',
        'comentario',
        'fecha_aprobacion',
        'fecha_rechazo',
        'fecha_cancelacion',
        'cancelado_por',
        'type',
        'slot_id',
    ];

    protected $appends = ['estado', 'nombre', 'human_readable_date','curso'];

    /**
     * Opciones de configuración para el log de actividad
     */

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->setDescriptionForEvent(fn (string $eventName) => "La reserva #" . $this->id . " (" . $this->reservable->nombre . ")
               ha sido " . __('messages.' . $eventName))
            ->useLogName('reservas')
            ->logOnly(['reservable_id', 'reservable_type', 'asignado_a', 'fecha', 'hora_inicio', 'hora_fin', 'comentario', 'fecha_aprobacion', 'fecha_rechazo', 'fecha_cancelacion', 'cancelado_por', 'type']);
    }

    /**
     * Obtener el modelo al que se le asignó la reserva.
     *
     * @return MorphTo
     */
    public function reservable(): MorphTo
    {
        return $this->morphTo();
    }


    /**
     * Obtener el usuario al que se le asignó la reserva
     * @return BelongsTo
     */
    public function usuario(): BelongsTo
    {
        return $this->belongsTo(User::class, 'asignado_a');
    }

    /**
     * Obtener el slot al que pertenece la reserva
     * @return BelongsTo
     */
    public function slot(): BelongsTo
    {
        return $this->belongsTo(CursoSlot::class);
    }

    /**
     * Obtener el curso al que pertenece la reserva
     * @return BelongsTo
     */
    public function curso(): BelongsTo|null
    {
        return $this->slot ? $this->slot->curso() :null;
    }

    /**
     * Obtener si la reserva está aprobada, o cancelada o rechazada
     * @return string
     */
    public function estado(): string
    {
        return match (true) {
            $this->fechaPasada() => 'cerrada',
            $this->fecha_aprobacion !== null => 'aprobada',
            $this->fecha_cancelacion !== null => 'cancelada',
            $this->fecha_rechazo !== null => 'rechazada',
            default => 'pendiente',
        };
    }

    public function fechaPasada(): bool
    {
        // Fecha de la reserva + hora de fin.
        $fechaFin = Carbon::parse($this->fecha . ' ' . $this->hora_fin);
        return $fechaFin->isPast();

    }

    /**
     * Scope para obtener las reservas de un usuario
     */
    public function scopeSegunUsuario(Builder $query): void
    {
        auth()->user()?->hasRole('Administrador') ? $query : $query->where('asignado_a', auth()->id());
    }

    /**
     * @return string
     */
    public function getEstadoAttribute(): string
    {
        return $this->estado();
    }

    /**
     * @return string
     */
    public function getNombreAttribute(): string
    {
        return $this->reservable->nombre;
    }

    /**
     * @return string
     */
    public function getHumanReadableDateAttribute(): string
    {
        // Ejemplo... Lunes 12 de Julio de 2021 de 10:00 a 12:00...

        $fecha = Carbon::parse($this->fecha);
        $horaInicio = Carbon::parse($this->hora_inicio);
        $horaFin = Carbon::parse($this->hora_fin);

        return $fecha->isoFormat('dddd D [de] MMMM [de] YYYY') . ' de ' . $horaInicio->format('H:i') . 'h. a ' . $horaFin->format('H:i') . 'h.';
    }

    /**
     * @return string
     */
    public function getCursoAttribute(): string
    {
        return $this->curso()?->first()->nombre ?? 'Reserva puntual';
    }

    /**
     * Reservas pendientes de aprobación
     */
    public function scopePendientes(Builder $query): void
    {
        $query->whereNull('fecha_aprobacion')
            ->whereNull('fecha_rechazo')
            ->whereNull('fecha_cancelacion');
    }

    /**
     * Tiene conflicto
     */

    public function tieneConflictos(): bool
    {
        $reservas = Reserva::where('reservable_id', $this->reservable_id)
        ->where('fecha', $this->fecha)
        ->where(function ($query) {
            $query->where(function ($q) {
                // Caso 1: La nueva reserva comienza durante una reserva existente
                $q->where('hora_inicio', '<=', $this->hora_inicio)
                  ->where('hora_fin', '>', $this->hora_inicio);
            })->orWhere(function ($q) {
                // Caso 2: La nueva reserva termina durante una reserva existente
                $q->where('hora_inicio', '<', $this->hora_fin)
                  ->where('hora_fin', '>=', $this->hora_fin);
            })->orWhere(function ($q) {
                // Caso 3: La nueva reserva engloba completamente una reserva existente
                $q->where('hora_inicio', '>=', $this->hora_inicio)
                  ->where('hora_fin', '<=', $this->hora_fin);
            });
        })
        ->where('id', '!=', $this->id)
        ->get();

        Log::debug('La reserva ' . $this->id . ' tiene ' . $reservas->count() . ' conflictos con: ' . $reservas->pluck('id')->implode(','));
            
        return $reservas->count() > 0;
    }

    


}
