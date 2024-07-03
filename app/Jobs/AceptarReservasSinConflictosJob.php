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
use Log;

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

            Log::debug('RESERVAS: ' . json_encode($this->reservas));
            foreach ($this->reservas as $reserva) {

                $tReserva = Reserva::where('id', $reserva)->first();

                if ($tReserva->estado() != 'pendiente') {
                    \Log::debug('Reserva ya aprobada o rechazada');
                    continue;
                }
                $tReserva->fecha_aprobacion = now();
                $tReserva->save();

                \Log::debug('Reserva ' . $tReserva->id . ' aprobada');

                // Notificar a los docentes del curso
                /** @phpstan-ignore-next-line */
                $tReserva->curso->docentes->each(function ($docente) use ($tReserva) {
                    $docente->notify(new SuccessNotification('Reserva #' . $tReserva->id . ' correspondiente al curso ' . $tReserva->curso->nombre . ' confirmada en fecha ' . $tReserva->fecha . ' de ' . $tReserva->hora_inicio . ' a ' . $tReserva->hora_fin));
                });
            }
        } catch (\Exception $e) {
            \Log::error('Error al aceptar reservas sin conflictos: ' . $e->getMessage());
            \Log::error($e->getTraceAsString());
            \Log::error($e->getLine());
            $this->tarea->update([
                'estado' => 'error',
                'fecha_fin' => now(),
                'resultado' => $e->getMessage(),
            ]);
        }

        $this->tarea->update([
            'estado' => 'completado',
            'resultado' => 'Reservas aceptadas sin conflictos',
            'fecha_fin' => now(),
        ]);
    }
}
