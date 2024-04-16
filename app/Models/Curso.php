<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Curso extends Model
{
    const TABLA = 'cursos';

    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;

    /**
     * Obtener las asignaturas de un curso
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function asignaturas()
    {
        return $this->hasMany(Asignatura::class);
    }

    /**
     * Obtener el docente de un curso
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function docente()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtener los alumnos de un curso
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function alumnos()
    {
        return $this->belongsToMany(User::class, 'alumno_curso', 'curso_id', 'alumno_id');
    }

    /**
     * Obtener los horarios de un curso
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function horarios()
    {
        return $this->hasMany(Horario::class);
    }
}
