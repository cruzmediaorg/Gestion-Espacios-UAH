<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipamiento extends Model
{
    const TABLA = 'equipamientos';

    use SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad',
    ];

    /**
     * Obtener los espacios asociados al equipamiento
     * @return BelongsToMany
     */
    public function espacios(): BelongsToMany
    {
        return $this->belongsToMany(Espacio::class);
    }
}
