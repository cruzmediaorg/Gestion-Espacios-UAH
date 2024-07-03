<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\CursoSlot;
use App\Models\Tarea;
use App\Models\TipoTarea;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CursoSlotController extends Controller
{

    public function store(Request $request)
    {
        $request->validate([
            'curso_id' => 'required|exists:cursos,id',
            'fecha' => 'required|date',
            'horaInicio' => 'required',
            'horaFin' => 'required',
        ]);


        $horaInicio = Carbon::createFromFormat('H:i', $request->horaInicio);
        $horaFin = Carbon::createFromFormat('H:i', $request->horaFin);

        if ($horaInicio->greaterThanOrEqualTo($horaFin)) {
            return redirect()->back()->withErrors(['horaInicio' => 'La hora de inicio debe ser menor a la hora de fin']);
        }

        // Si ya ha pasado la fecha y hora actual... (2 horas de margen debe existir)
        $fechaYHoraInicio = Carbon::parse($request->fecha . ' ' . $request->horaInicio);

      // Primero vemos si es de hoy

        // Si se intenta poner una fecha anterior a la actual
        if ($fechaYHoraInicio->lessThan(now())) {
            return redirect()->back()->withErrors(['horaInicio' => 'No se puede reservar en una fecha pasada']);
        }


        if ($fechaYHoraInicio->isToday() && $fechaYHoraInicio->lessThanOrEqualTo(now()->addHours(2))) {
            return redirect()->back()->withErrors(['horaInicio' => 'Se debe reservar con al menos 2 horas de antelación']);
        }



        if (CursoSlot::where('curso_id', $request->curso_id)
            ->where('dia', $request->fecha)
            ->where('hora_inicio', $request->horaInicio)
            ->where('hora_fin', $request->horaFin)
            ->exists()) {
            return redirect()->back()->withErrors(['horaInicio' => 'Ya existe una clase con esa hora']);
        }

        $curso = Curso::find($request->curso_id);

        $curso->slots()->create([
            'dia' => $request->fecha,
            'hora_inicio' => $request->horaInicio,
            'hora_fin' => $request->horaFin,
        ]);

        return redirect()->route('cursos.show', $curso->id)->with('success', 'Clase creada correctamente');
    }

    public function update($slot)
    {
        $slot = CursoSlot::find($slot);

        $slot->update([
            'dia' => request('fecha'),
            'hora_inicio' => request('horaInicio'),
            'hora_fin' => request('horaFin'),
        ]);

        return redirect()->route('cursos.show', $slot->curso->id)->with('success', 'Clase actualizada correctamente');
    }

    public function destroy($slot)
    {
        $slot = CursoSlot::find($slot);

        $curso = $slot->curso;

        $slot->delete();

        return redirect()->route('cursos.show', $curso->id)->with('success', 'Clase eliminada correctamente');
    }

    public function generarReservas(Curso $curso)
    {

        // Verificar si el curso tiene slots
        if ($curso->slots->isEmpty()) {
            return redirect()->route('cursos.show', $curso->id)->with('error', 'El curso no tiene clases');
        }

        // Verificar si el curso tiene slots sin reservas
        if ($curso->slotsSinReserva->isEmpty()) {
            return redirect()->route('cursos.show', $curso->id)->with('error', 'Todos los horarios ya tienen espacio reservado');
        }



        $tipoTarea = TipoTarea::where('alias', 'crear_reservas_sin_slots')->first();
        $claseTipoTarea = 'App\Jobs\\' . $tipoTarea->clasePHP;

        $tarea = Tarea::create([
            'tipo_tarea_id' => $tipoTarea->id,
            'estado' => 'pendiente',
            'fecha_inicio' => now(),
        ]);

        $arrayCursos = [
            'cursos' => $curso->id,
        ];

        dispatch(new $claseTipoTarea($tarea->id, $arrayCursos, false));

        return redirect()->route('cursos.show', $curso->id)->with('success', 'Reservas generadas correctamente');
    }
}
