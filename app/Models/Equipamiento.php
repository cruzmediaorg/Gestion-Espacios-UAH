<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipamiento extends Model
{
    const TABLA = 'equipamientos';

    use HasFactory, SoftDeletes;

    protected $table = self::TABLA;

    protected $fillable = [
        'nombre',
        'descripcion',
        'cantidad',
    ];

    /**
     * Obtener los espacios asociados al equipamiento
     * BelongsToMany
     */

    public function espacios()
    {
        return $this->belongsToMany(Espacio::class);
    }
}
