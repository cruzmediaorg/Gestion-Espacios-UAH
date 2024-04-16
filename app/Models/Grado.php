<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Grado extends Model
{
    const TABLA = 'grados';

    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'tipoGrado_id'];


    /*
    * Obtiene el tipo de grado al que pertenece el grado
    * @return \Illuminate\Database\Eloquent\Relations\HasOne
    */
    public function tipoGrado()
    {
        return $this->hasOne(TipoGrado::class, 'id', 'tipoGrado_id');
    }

    /**
     * Asignaturas que pertenecen a un grado
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function asignaturas()
    {
        return $this->belongsToMany(Asignatura::class, 'asignatura_grado', 'grado_id', 'asignatura_id');
    }
}
