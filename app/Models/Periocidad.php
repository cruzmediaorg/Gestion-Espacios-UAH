<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periocidad extends Model
{
    const TABLA = 'periocidades';

    use SoftDeletes;

    protected $table = self::TABLA;
}
