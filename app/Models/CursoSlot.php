<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CursoSlot extends Model
{
    protected $table = 'curso_slots';

    protected $guarded = [];

//    protected function casts()
//    {
//        return [
//            'dia' => 'date',
//        ];
//    }

    /**
     * Obtener el curso al que pertenece el slot
     * @return BelongsTo
     */
    public function curso()
    {
        return $this->belongsTo(Curso::class);
    }

    /**
     * Obtener las reservas de un slot
     * @return HasMany
     */
    public function reservas(): HasMany
    {
        return $this->hasMany(Reserva::class, 'slot_id');
    }
}
