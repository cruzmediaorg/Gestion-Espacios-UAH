<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $nombre
 * @property string $color
 */
class TipoEspacio extends Model
{
    const TABLA = 'tiposEspacios';
    use SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = [
        'nombre',
        'color',
    ];

    /**
     * Obtener las características asociadas al tipo de espacio
     * @return BelongsToMany<Caracteristica>
     */
    public function caracteristicas(): BelongsToMany
    {
        return $this->belongsToMany(Caracteristica::class, 'caracteristica_tipoespacio', 'tiposespacios_id', 'caracteristica_id');
    }
}
