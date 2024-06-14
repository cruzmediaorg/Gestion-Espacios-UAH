<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localizacion extends Model
{

    const TABLA = 'localizaciones';

    use SoftDeletes;

    protected $table = self::TABLA;
}
