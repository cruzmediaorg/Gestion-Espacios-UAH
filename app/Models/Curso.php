<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    const TABLA = 'cursos';

    use SoftDeletes;

    protected $table = self::TABLA;

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
     * Obtener los horarios de un curso
     * @return HasMany
     */
    public function horarios(): HasMany
    {
        return $this->hasMany(Horario::class);
    }

    /**
     * Obtener el periodo de un curso
     * @return BelongsTo
     */
    public function periodo(): BelongsTo
    {
        return $this->belongsTo(Periodo::class);
    }
}
