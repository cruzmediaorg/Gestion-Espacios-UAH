<?php

namespace App\Jobs;

use App\Models\Tarea;
use Database\Factories\EspacioFactory;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class CargaCSVAsignaturas implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tarea;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $tareaId
    ) {
        $this->tarea = Tarea::find($tareaId);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $this->tarea->estado = 'EN EJECUCIÓN';
        $this->tarea->fecha_ejecucion = now();
        $this->tarea->save();

        try {
            // Aquí va el código que se ejecutará cuando se ejecute la tarea
            Log::info('Ejecutando tarea ' . $this->tarea->tipoTarea->nombre);

            // Simulamos un proceso de carga de datos
            for ($i = 0; $i < 100; $i++) {
                EspacioFactory::new()->create();
                Log::debug('Creado espacio ' . $i);
            }

            // Si la tarea se ejecuta correctamente, se marca como completada
            $this->tarea->estado = 'COMPLETADA';
            $this->tarea->resultado = 'Carga de asignaturas completada';
            $this->tarea->fecha_fin = now();
            $this->tarea->save();


            $this->tarea->save();
        } catch (\Exception $e) {
            // Si se produce un error, se marca como fallida
            $this->tarea->estado = 'FALLIDA';
            $this->tarea->fecha_fin = now();
            $this->tarea->resultado = $e->getMessage();
            $this->tarea->save();

            Log::error('Error al ejecutar tarea ' . $this->tarea->tipoTarea->nombre . ': ' . $e->getMessage());
        }
    }
}
