<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $nombre
 * @property string $descripcion
 * @property string $created_at
 * @property string $updated_at
 * @property string $deleted_at
 */
class TipoGrado extends Model
{
    const TABLA = 'tiposGrados';

    use SoftDeletes;

    protected $fillable = ['nombre', 'descripcion'];

    protected $table = self::TABLA;
}
