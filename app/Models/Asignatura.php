<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;


/**
 * @property int $id
 * @property string $nombre
 * @property string $codigo
 */
class Asignatura extends Model
{
    const TABLA = 'asignaturas';

    use SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = [
        'nombre',
        'codigo',
    ];

}
