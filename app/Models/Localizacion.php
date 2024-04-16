<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Localizacion extends Model
{

    const TABLA = 'localizaciones';

    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;
}
