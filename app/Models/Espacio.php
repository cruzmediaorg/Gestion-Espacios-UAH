<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Espacio extends Model
{
    const TABLA = 'espacios';
    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = [
        'nombre',
        'localizacion_id',
        'tiposespacio_id',
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
     * Obtener los equipamientos asociados al espacio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function equipamientos()
    {
        return $this->belongsToMany(Equipamiento::class, 'espacio_equipamiento', 'espacio_id', 'equipamiento_id');
    }
}
