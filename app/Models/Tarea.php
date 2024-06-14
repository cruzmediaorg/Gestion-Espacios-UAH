<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tarea extends Model
{
    const TABLA = 'Tarea';
    use SoftDeletes;

    protected $table = 'tareas';

    protected $fillable = [
        'tipo_tarea_id',
        'fecha_inicio',
        'fecha_fin',
        'fecha_ejecucion',
        'estado',
        'resultado'

    ];

    /**
     * @return BelongsTo
     */
    public function tipoTarea(): BelongsTo
    {
        return $this->belongsTo(TipoTarea::class);
    }
}
