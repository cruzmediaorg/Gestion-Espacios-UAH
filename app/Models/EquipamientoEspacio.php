<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class EquipamientoEspacio extends Pivot
{
    const TABLA = 'equipamiento_espacio';
    use HasFactory;

    protected $table = self::TABLA;

    protected $fillable = [
        'espacio_id',
        'equipamiento_id',
        'cantidad',
    ];

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Obtener el espacio asociado al equipamiento
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function espacio()
    {
        return $this->belongsTo(Espacio::class);
    }

    /**
     * Obtener el equipamiento asociado al espacio
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */

    public function equipamiento()
    {
        return $this->belongsTo(Equipamiento::class);
    }
}
