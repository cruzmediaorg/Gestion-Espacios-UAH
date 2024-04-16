<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AlumnoCurso extends Model
{
    const TABLA = 'alumno_curso';

    use HasFactory, SoftDeletes;
}
