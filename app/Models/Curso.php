<?php

namespace App\Models;

use App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nombre
 * @property string $codigo
 * @property int $asignatura_id
 * @property int $periodo_id
 * @property int $alumnos_matriculados
 */
class Curso extends Model
{
    const TABLA = 'cursos';

    use SoftDeletes;

    protected $table = self::TABLA;

    protected $guarded = [];

    /**
     * Obtener las asignaturas de un curso
     * @return BelongsTo
     */
    public function asignatura(): BelongsTo
    {
        return $this->belongsTo(Asignatura::class);
    }

    /**
     * Obtener los docentes de un curso
     * Tabla pivot curso_docente
     * @return BelongsToMany
     */
    public function docentes(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'curso_docente', 'curso_id', 'docente_id');
    }

    /**
     * Obtener el periodo de un curso
     * @return BelongsTo
     */
    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class);
    }

    /**
     * Obtener los slots de un curso (Clases)
     * @return HasMany
     */
    public function slots(): HasMany
    {
        return $this->hasMany(CursoSlot::class);
    }

    /**
     * Obtener los slots que no tienen reserva
     * @return HasMany
     */
    public function slotsSinReserva(): HasMany
    {
        return $this->slots()
            ->whereDoesntHave('reservas');
    }

    /**
     * Obtener las reservas de un curso (Con los slots)
     * @return HasMany<App\Models\CursoSlot>
     */
    public function reservas(): HasMany
    {
        return $this->slots()
            ->whereHas('reservas')
            ->with('reservas');
    }
}
