<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TipoGrado extends Model
{
    const TABLA = 'tiposGrados';

    use HasFactory, SoftDeletes;

    protected $fillable = ['nombre', 'descripcion'];

    protected $table = self::TABLA;
}
