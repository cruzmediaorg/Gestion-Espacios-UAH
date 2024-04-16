<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AsignaturaGrado extends Model
{
    const TABLA = 'asignatura_grado';

    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = ['asignatura_id', 'grado_id'];

    /**
     * Obtiene la asignatura a la que pertenece el grado
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function asignatura()
    {
        return $this->belongsTo(Asignatura::class, 'asignatura_id');
    }

    /**
     * Obtiene el grado al que pertenece la asignatura
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function grado()
    {
        return $this->belongsTo(Grado::class, 'grado_id');
    }
}
