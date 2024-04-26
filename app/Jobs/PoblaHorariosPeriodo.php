<?php

namespace App\Jobs;

use App\Models\Curso;
use App\Models\Horario;
use App\Models\Periodo;
use App\Models\Tarea;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

/**
 * @property int $curso_id
 * @property string $fecha_inicio
 * @property string $fecha_fin
 */
class PoblaHorariosPeriodo implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $tarea;
    public $tareaId;
    public $parametros;

    /**
     * Create a new job instance.
     * @param int $tareaId
     */
    public function __construct(int $tareaId, $parametros)
    {
        $this->tareaId = $tareaId;
        $this->tarea = Tarea::find($tareaId);
        $this->parametros = $parametros;
    }

    public function handle(): void
    {

        $tarea = Tarea::find($this->tareaId);

        $tarea->update(['estado' => 'Ejecutando', 'fecha_ejecucion' => now()]);

        $periodo = Periodo::where('nombre', $this->parametros['periodo'])->first();
        if (!$periodo) {
            Log::error('No se ha encontrado el periodo ' . $this->parametros['periodo']);
            $tarea->update(['estado' => 'Error', 'resultado' => 'No se ha encontrado el periodo ' . $this->parametros['periodo']]);
            return;
        }

        $cursos = Curso::where('periodo_id', $periodo->id)->get();

        foreach ($cursos as $curso) {
            $curso->horarios()->delete();
            $this->poblarHorarios($curso);
        }

        $tarea->update(['estado' => 'Completado', 'resultado' => 'Horarios poblados para el periodo ' . $periodo->nombre]);

        return;
    }

    private function poblarHorarios($curso)
    {
        $curso->horarios()->delete();

        // $curso->dias = Esto es un string con los días de la semana que se imparte el curso en formato (LMXJVSD)
        // sin espacios ni caracteres especiales. Ejemplo: 'LMXV'
        // hora de inicio esta en curso->hora_inicio
        // hora de fin esta en curso->hora_fin
        $diasCurso = str_split($curso->dias);
        $inicioPeriodo = Carbon::createFromDate($curso->periodo->fecha_inicio);
        $finPeriodo = Carbon::createFromDate($curso->periodo->fecha_fin);
        $horaInicio = Carbon::createFromTimeString($curso->hora_inicio);
        $horaFin = Carbon::createFromTimeString($curso->hora_fin);
        $cantidadHoras = $curso->cantidad_horas;
        $dias = ['L', 'M', 'X', 'J', 'V', 'S', 'D'];

        // Vamos a crear un horario para cada día de la semana que se imparte el curso
        // Durante el periodo de tiempo que dura el curso (inicioPeriodo - finPeriodo)
        // Hasta que se completen las horas del curso
        // Por ejemplo, si un curso se imparte los viernes de 16:00 a 21:00 y su cantidad de horas es 10
        // Solo se impartirá durante 2 viernes consecutivos de 16:00 a 21:00
        $fecha = $inicioPeriodo->copy();

        foreach ($diasCurso as $diaCurso) {
            $dia = array_search($diaCurso, $dias);
            $horasImpartidas = 0;

            while ($fecha->lte($finPeriodo) && $horasImpartidas <= $cantidadHoras) {
                $horario = new Horario();
                $horario->curso_id = $curso->id;
                $horario->fecha = $fecha;
                $horario->hora_inicio = $horaInicio;
                $horario->hora_fin = $horaFin;
                $horario->save();

                $horasImpartidas += $horaInicio->diffInHours($horaFin);
                $fecha->addWeek();
            }
        }









        return true;
    }
}
