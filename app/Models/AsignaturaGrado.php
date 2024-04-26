<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $asignatura_id
 * @property int $grado_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 * @property Asignatura $asignatura
 * @property Grado $grado
 */
class AsignaturaGrado extends Model
{
    const TABLA = 'asignatura_grado';

    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = ['asignatura_id', 'grado_id', 'periocidad_id'];

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
