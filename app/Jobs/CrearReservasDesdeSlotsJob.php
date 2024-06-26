<?php

namespace App\Jobs;

use App\Models\Curso;
use App\Models\Espacio;
use App\Models\Periodo;
use App\Models\Reserva;
use App\Models\Tarea;
use App\Models\TipoTarea;
use App\Notifications\ErrorNotification;
use App\Notifications\SuccessNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class CrearReservasDesdeSlotsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $slot;
    private Curso $curso;
    private array $slots;
    private Periodo $periodo;
    private Tarea $tarea;

    public function __construct(
        $curso,
        $slots,
        $periodo,
        $tarea
    ) {
        $this->curso = $curso;
        $this->slots = $slots;
        $this->periodo = $periodo;
        $this->tarea = $tarea;
    }

    public function handle(): void
    {
        $this->tarea->update([
            'estado' => 'procesando',
            'fecha_ejecucion' => now(),
        ]);

        $cantidadSlots = count($this->slots);
        $cantidadAlumnos = $this->curso->alumnos_matriculados;

        try {
            // 1. Validamos si las fechas de los slots están dentro del periodo.
            $validados = $this->validarSlots();

            if ($validados) {

                // 2. Segun la cantidad de alumnos, buscamos un espacio cuya capacidad sea mayor o igual a la cantidad de alumnos.
                $espacios = Espacio::where('capacidad', '>=', $cantidadAlumnos)
                    ->get();

                // 3. Si no hay espacios disponibles, retornamos un error.
                if ($espacios->isEmpty()) {
                    throw new \Exception('No hay espacios disponibles para la cantidad de alumnos');
                }

                // 4. Si hay espacios con esta capacidad, verificamos si hay disponibilidad en el horario de los slots. (Para siempre usar el mismo espacio)
                $espacioEncontrado = false;
                $disponibilidad = [];
                $espacio = null;

                foreach ($espacios as $espacio) {
                    $disponibilidad = $this->verificarDisponibilidad($espacio, $this->slots);
                    if ($disponibilidad) {
                        $espacioEncontrado = true;
                        $espacio = $espacio;
                        break;
                    }
                }

                if (!$espacioEncontrado) {
                    throw new \Exception('No hay disponibilidad en los espacios');
                }

                $reservas = [];

                // 5. Si hay disponibilidad, creamos las reservas.
                foreach ($disponibilidad as $slot) {
                    $reserva = new Reserva();
                    $reserva->curso_id = $this->curso->id;
                    $reserva->reservable_id = $espacio->id;
                    $reserva->asignado_a = $this->curso->docentes->first()->id;
                    $reserva->reservable_type = Espacio::class;
                    $reserva->fecha = $slot['fecha'];
                    $reserva->hora_inicio = $slot['hora_inicio'];
                    $reserva->hora_fin = $slot['hora_fin'];
                    $reserva->comentario = 'Reserva creada automáticamente al crear un curso';
                    $reserva->type = 'Otro';
                    $reserva->save();

                    $reservas[] = $reserva->id;
                }

                // 6. Si las reservas se crearon correctamente.
                if (count($reservas) === $cantidadSlots) {
                    \Log::info('Se han creado las reservas correctamente', ['reservas' => $reservas]);
                    $this->tarea->update([
                        'estado' => 'completado',
                        'fecha_fin' => now(),
                        'resultado' => 'Se han creado las reservas correctamente',
                    ]);

                    $tarea = Tarea::create([
                        'tipo_tarea_id' => TipoTarea::where('alias', 'aceptar_reservas_sin_conflictos')->first()->id,
                        'estado' => 'pendiente',
                        'fecha_inicio' => now(),
                    ]);

                    // 6.5. Notificar a los docentes del curso
                    $this->curso->docentes->each(function ($docente) use ($reservas) {
                        $docente->notify(new SuccessNotification('Se han creado ' . count($reservas) . '
                        reservas correspondiente al curso ' . $this->curso->nombre . ' correctamente.'));
                    });

                    // 7. Aceptamos las reservas sin conflictos.
                    AceptarReservasSinConflictosJob::dispatch($reservas, $tarea)->delay(now()->addDay());
                }
            }
        } catch (\Exception $e) {
            $this->tarea->update([
                'estado' => 'error',
                'fecha_fin' => now(),
                'resultado' => $e->getMessage(),
            ]);

            // Notificar error a los docentes del curso
            $this->curso->docentes->each(function ($docente) use ($e) {
                Log::debug('Notificando error a los docentes del curso');
                Log::debug('Mensaje de error: ' . $e->getMessage());
                $docente->notify(new ErrorNotification('Error al crear las reservas. Favor, contactar al administrador del sistema.'));
            });

            \Log::error('Ha ocurrido un error: ' . $e->getMessage());
            \Log::error('Linea: ' . $e->getLine());
            \Log::error('Archivo: ' . $e->getFile());
            \Log::error('Trace: ' . $e->getTraceAsString());

            return;
        }
    }

    private function validarSlots(): bool
    {
        foreach ($this->slots as $slot) {
            $fecha = $slot['fecha'];
            $fecha = new \DateTime($fecha);
            $fecha = $fecha->format('Y-m-d');

            $periodo = Periodo::where('fecha_inicio', '<=', $fecha)
                ->where('fecha_fin', '>=', $fecha)
                ->first();

            if (!$periodo) {
                \Log::error('La fecha del slot no está dentro del periodo', ['fecha' => $fecha]);


                $mensaje = 'La fecha ' . $fecha . ' para la creación de reservas en el curso ' . $this->curso->nombre . '
                     no está dentro del periodo admitido: ' . $this->periodo->nombre . '. Favor, intentar con otra fecha.';

                // Notificar error a los docentes del curso
                $this->curso->docentes->each(function ($docente) use ($mensaje) {
                    $docente->notify(new ErrorNotification($mensaje));
                    // Borramos el curso

                    $this->curso->delete();

                    // Marcamos la tarea como error
                    $this->tarea->update([
                        'estado' => 'error',
                        'fecha_fin' => now(),
                        'resultado' => $mensaje,
                    ]);

                    return false;
                });
            }
        }

        return true;
    }

    private function verificarDisponibilidad(Espacio|\Closure|null $espacio, array $slots)
    {
        $disponibilidad = $espacio->disponibilidad($slots);

        if (empty($disponibilidad)) {
            throw new \Exception('No hay disponibilidad en el espacio');
        }

        Log::debug('SI HAY DISPONIBILIDAD', ['disponibilidad' => $disponibilidad]);

        return $disponibilidad;
    }
}
