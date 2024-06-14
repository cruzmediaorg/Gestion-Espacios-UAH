<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $curso_id
 * @property string $fecha
 * @property string $hora_inicio
 * @property string $hora_fin
 */
class Horario extends Model
{
    const TABLA = 'horarios';

    use SoftDeletes;
}
