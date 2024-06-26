<?php

namespace App\Jobs;

use App\Models\Reserva;
use App\Notifications\ErrorNotification;
use App\Notifications\SuccessNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class AceptarReservasSinConflictosJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $reservas;
    private $tarea;
    public function __construct($reservas, $tarea)
    {
        $this->reservas = $reservas;
        $this->tarea = $tarea;
    }

    public function handle(): void
    {

        $this->tarea->update([
            'estado' => 'procesando',
            'fecha_ejecucion' => now(),
        ]);


        try {
            foreach ($this->reservas as $reserva) {

                $reserva = Reserva::where('id', $reserva)->first();

                if ($reserva->estado() != 'pendiente') {
                    \Log::debug('Reserva ya aprobada o rechazada');
                    continue;
                }
                $reserva->fecha_aprobacion = now();
                $reserva->save();

                \Log::debug('Reserva ' . $reserva->id . ' aprobada');

                // Notificar a los docentes del curso
                $reserva->curso->docentes->each(function ($docente) use ($reserva) {
                    $docente->notify(new SuccessNotification('Reserva #' . $reserva->id . ' correspondiente al curso ' . $reserva->curso->nombre . ' confirmada en fecha ' . $reserva->fecha . ' de ' . $reserva->hora_inicio . ' a ' . $reserva->hora_fin));
                });
            }
        } catch (\Exception $e) {
            \Log::error('Error al aceptar reservas sin conflictos: ' . $e->getMessage());
            $this->tarea->update([
                'estado' => 'error',
                'fecha_fin' => now(),
                'resultado' => $e->getMessage(),
            ]);

            // Notificar error a los docentes del curso
            $this->tarea->curso->docentes->each(function ($docente) use ($e) {
                $docente->notify(new ErrorNotification($e->getMessage()));
            });
        }

        $this->tarea->update([
            'estado' => 'completado',
            'resultado' => 'Reservas aceptadas sin conflictos',
            'fecha_fin' => now(),
        ]);
    }
}
