<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nombre
 * @property int $tipoGrado_id
 * @property string $codigo
 * @property string $created_at
 * @property string $updated_at
 * @property TipoGrado $tipoGrado
 * @property Asignatura[] $asignaturas
 */
class Grado extends Model
{
    const TABLA = 'grados';

    use SoftDeletes;

    protected $fillable = ['nombre', 'tipoGrado_id', 'codigo'];


    /**
    * Obtiene el tipo de grado al que pertenece el grado
    * @return HasOne
    */
    public function tipoGrado(): HasOne
    {
        return $this->hasOne(TipoGrado::class, 'id', 'tipoGrado_id');
    }

    /**
     * Asignaturas que pertenecen a un grado
     * @return BelongsToMany
     */
    public function asignaturas(): BelongsToMany
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_grado', 'grado_id', 'asignatura_id')->withPivot('id');
    }
}
