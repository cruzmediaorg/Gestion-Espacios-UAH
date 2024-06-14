<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $nombre
 * @property string $fecha_inicio
 * @property string $fecha_fin
 */
class Periodo extends Model
{
    const TABLA = 'periodos';
    use SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = ['nombre', 'fecha_inicio', 'fecha_fin'];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date'
    ];

    /**
     * @return HasMany
     */
    public function cursos(): HasMany
    {
        return $this->hasMany(Curso::class, 'periodo_id');
    }
}
