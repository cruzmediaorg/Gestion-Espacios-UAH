<?php

namespace App\Jobs;

use App\Models\Reserva;
use App\Models\Tarea;
use App\Notifications\ErrorNotification;
use App\Notifications\SuccessNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class AceptarReservasSinConflictosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;


    protected $reservas;
    private $tarea;

    public function __construct($tareaId, $reservas = [])
    {
        $this->tarea = Tarea::find($tareaId);
        if ($reservas) {
            $this->reservas = Reserva::whereIn('id', $reservas)->get();
        } else {
            $this->reservas = Reserva::pendientes()->get();
        }
        
    }

    public function handle(): void
    {

        $this->tarea->update([
            'estado' => 'procesando',
            'fecha_ejecucion' => now(),
        ]);
        

        $reservas = $this->reservas;

        if ($reservas->count() === 0) {
            $this->tarea->update([
                'estado' => 'completado',
                'fecha_finalizacion' => now(),
                'resultado' => 'No hay reservas pendientes.',
            ]);
            return;
        }


        $reservasAprobadas = 0;
        $reservasRechazadas = 0;

        foreach ($reservas as $reserva) {
            if ($reserva->tieneConflictos()) {
                $reserva->update([
                    'fecha_rechazo' => now(),
                    'comentario' => 'Reserva rechazada por conflictos con otras reservas.',
                ]);
                $reservasRechazadas++;
            } else {
                $reserva->update([
                    'fecha_aprobacion' => now(),
                    'comentario' => $reserva->comentario . '-  Reserva aprobada sin conflictos.',
                ]);
                $reservasAprobadas++;
            }
        }

        $this->tarea->update([
            'estado' => 'completado',
            'fecha_finalizacion' => now(),
            'resultado' => 'Reservas aprobadas: ' . $reservasAprobadas . ', Reservas rechazadas: ' . $reservasRechazadas,
        ]);
        
        
     
    }

    
}
