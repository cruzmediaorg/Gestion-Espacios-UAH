<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property array $parametros_requeridos
 * @property string $nombre
 * @property string $alias
 * @property string $descripcion
 * @property string $clasePHP
 * @property string $periocidad
 */
class TipoTarea extends Model
{
    const TABLA = 'tiposTareas';
    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = ['nombre', 'alias', 'descripcion', 'clasePHP', 'periocidad', 'parametros_requeridos'];

    protected $casts = [
        'parametros_requeridos' => 'array'
    ];
}
