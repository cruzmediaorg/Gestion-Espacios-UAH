<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $nombre
 * @property string $color
 */
class TipoEspacio extends Model
{
    const TABLA = 'tiposEspacios';
    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = [
        'nombre',
        'color',
    ];

    /**
     * Obtener las características asociadas al tipo de espacio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany<Caracteristica>
     */

    public function caracteristicas()
    {
        return $this->belongsToMany(Caracteristica::class, 'caracteristica_tipoespacio', 'tiposespacios_id', 'caracteristica_id');
    }
}
