<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    const TABLA = 'Tarea';
    use HasFactory, SoftDeletes;

    protected $table = 'tareas';

    protected $fillable = [
        'tipo_tarea_id',
        'fecha_inicio',
        'fecha_fin',
        'fecha_ejecucion',
        'estado',
        'resultado'

    ];

    public function tipoTarea()
    {
        return $this->belongsTo(TipoTarea::class);
    }
}
