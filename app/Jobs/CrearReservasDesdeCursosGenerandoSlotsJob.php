<?php

namespace App\Jobs;

use App\Models\Curso;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\Tarea;
use App\Models\TipoTarea;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;

class CrearReservasDesdeCursosGenerandoSlotsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tarea;

    protected $parametros;

    protected $cursos;

    private array $slots;

    /**
     * Create a new job instance.
     */

    public function __construct(
        public int $tareaId,
        public array $params,
        public bool $aceptarReservas = true
    ) {
        $this->tarea = Tarea::find($tareaId);
        $this->parametros = $params;
        $this->aceptarReservas = $aceptarReservas;

        // Ordenamos los cursos por cantidad de alumnos matriculados.
        if (strtolower($this->params['cursos']) === 'todos') {
            $this->cursos = Curso::orderByDesc('alumnos_matriculados')->get();
        } else {
            $cursosIds = explode(',', $this->params['cursos']);
            $this->cursos = Curso::whereIn('id', $cursosIds)->orderByDesc('alumnos_matriculados')->get();
        }
    }

    public function handle(): void
    {
        // Empezamos la tarea...
        $this->tarea->update([
            'estado' => 'procesando',
            'fecha_ejecucion' => now(),
        ]);

        // Si no se encontraron cursos, terminamos la tarea
        if ($this->cursos->isEmpty()) {
            $this->tarea->update([
                'estado' => 'error',
                'resultado' => 'No se encontraron cursos',
                'fecha_fin' => now(),
            ]);
            return;
        }

        // Obtenemos los slots sin reserva de los cursos.
        $slotsSinReserva = [];

        foreach ($this->cursos as $curso) {
            $slots = $curso->slotsSinReserva;
            $slotsSinReserva = array_merge($slotsSinReserva, $slots->toArray());
        }

        $this->slots = $slotsSinReserva;

        if (empty($this->slots)) {
            $this->tarea->update([
                'estado' => 'completado',
                'resultado' => 'No se encontraron slots sin reserva',
                'fecha_fin' => now(),
            ]);
            return;
        }

        $reservas = $this->crearReservas();

        if (empty($reservas)) {
            $this->tarea->update([
                'estado' => 'error',
                'resultado' => 'No se pudieron crear las reservas',
                'fecha_fin' => now(),
            ]);
            return;
        } else {

            if (!$this->aceptarReservas) {
                $this->tarea->update([
                    'estado' => 'completado',
                    'resultado' => 'Se crearon ' . count($reservas) . ' reservas correctamente',
                    'fecha_fin' => now(),
                ]);
                return;
            }

            $tarea = Tarea::create([
                'tipo_tarea_id' => TipoTarea::where('alias', 'aceptar_reservas_sin_conflictos')->first()->id,
                'estado' => 'pendiente',
                'fecha_inicio' => now(),
            ]);

            AceptarReservasSinConflictosJob::dispatch($tarea->id, $reservas);

            $this->tarea->update([
                'estado' => 'completado',
                'resultado' => 'Se crearon ' . count($reservas) . ' reservas correctamente',
                'fecha_fin' => now(),
            ]);
        }
    }

    private function crearReservas()
    {
        $reservas = [];

        foreach ($this->slots as $slot) {
            $curso = Curso::find($slot['curso_id']);

            $espacio = $this->obtenerEspacio($curso, $slot);

            if ($espacio) {
                $reserva = Reserva::create([
                    'reservable_id' => $espacio->id,
                    'reservable_type' => Espacio::class,
                    'asignado_a' => $curso->docentes()->first()->id,
                    'fecha' => Carbon::parse($slot['dia']),
                    'hora_inicio' => $slot['hora_inicio'],
                    'hora_fin' => $slot['hora_fin'],
                    'comentario' => 'Reserva generada por tarea programada',
                    'type' => 'Otro',
                    'slot_id' => $slot['id'],
                ]);

                $reservas[] = $reserva->id;
            }
        }

        return $reservas;
    }

    private function obtenerEspacio(Curso $curso, $slot)
    {
        $espacioAnteriorId = $curso->reservas->last()?->reservas->first()?->reservable_id;

        if ($espacioAnteriorId) {
            $espacioAnterior = Espacio::find($espacioAnteriorId);
            $slots = [
                [
                    'fecha' => $slot['dia'],
                    'hora_inicio' => $slot['hora_inicio'],
                    'hora_fin' => $slot['hora_fin'],
                ]
            ];

            // Verificamos si el espacio tiene disponibilidad en el horario
            if ($espacioAnterior && $espacioAnterior->slotDisponible($slots)) {
                return $espacioAnterior;
            } else {
                $espacio = $this->buscarNuevoEspacio($curso, $slot);
                return $espacio;
            }
        }

        $espacio = $this->buscarNuevoEspacio($curso, $slot);

        return $espacio;
    }

    private function buscarNuevoEspacio(Curso $curso, $slot)
    {
        $espacios = Espacio::where('capacidad', '>=', $curso->alumnos_matriculados)
            ->whereIn('tiposespacios_id', [1, 2])
            ->whereDoesntHave('reservas', function ($query) use ($slot) {
                $query->where('fecha', $slot['dia'])
                    ->where(function ($q) use ($slot) {
                        $q->where(function ($subQ) use ($slot) {
                            // Caso 1: La nueva reserva comienza durante una reserva existente
                            $subQ->where('hora_inicio', '<=', $slot['hora_inicio'])
                                 ->where('hora_fin', '>', $slot['hora_inicio']);
                        })->orWhere(function ($subQ) use ($slot) {
                            // Caso 2: La nueva reserva termina durante una reserva existente
                            $subQ->where('hora_inicio', '<', $slot['hora_fin'])
                                 ->where('hora_fin', '>=', $slot['hora_fin']);
                        })->orWhere(function ($subQ) use ($slot) {
                            // Caso 3: La nueva reserva engloba completamente una reserva existente
                            $subQ->where('hora_inicio', '>=', $slot['hora_inicio'])
                                 ->where('hora_fin', '<=', $slot['hora_fin']);
                        });
                    });
            })
            ->orderBy('capacidad', 'desc')
            ->get();

        // Si hay múltiples espacios disponibles, seleccionar uno aleatoriamente
        if ($espacios->isNotEmpty()) {
            return $espacios->random();
        }

        return null;
    }
}
