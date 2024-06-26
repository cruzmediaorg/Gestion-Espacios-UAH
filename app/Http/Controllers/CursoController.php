<?php

namespace App\Http\Controllers;

use App\Events\NotificationCreatedEvent;
use App\Jobs\CrearReservasDesdeSlotsJob;
use App\Models\Asignatura;
use App\Models\Curso;
use App\Models\Periodo;
use App\Models\Tarea;
use App\Models\TipoTarea;
use App\Models\User;
use App\Notifications\CursoCreadoNotification;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CursoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        if ($request->user()->cannot('Ver cursos')) {
            return redirect()->route('sin-permisos');
        }

        $docente = User::find($request->user()->id);
        $cursos = $docente->cursos;

        return Inertia::render('Control/Cursos/Index', [
            'cursos' => $cursos->load(['asignatura', 'periodo'])->loadCount('docentes'),
            'periodos' => Periodo::all()->pluck('nombre', 'id'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $users = User::where('tipo', 'responsable')->orderBy('name')->get();

        $docentes = $users->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'label' => auth()->user()->id == $user->id ? $user->name . ' (Tú)' : $user->name,
            ];
        });

        // Ordenar y agregar el usuario actual al principio
        $docentes = $docentes->sortBy('label')->values()->all();

        return Inertia::render('Control/Cursos/Create', [
            'periodos' => Periodo::all()->pluck('nombre', 'id'),
            'docentes' => $docentes,
            'asignaturas' => Asignatura::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $request->validate([
            'dias' => 'required|array',
            'docentes' => 'required|array|min:1',
            'hora_inicio' => 'required',
            'hora_fin' => 'required',
            'fecha_inicio_periodo' => 'required',
            'asignatura' => 'required|exists:asignaturas,id',
            'slots' => 'sometimes|array',
            'total_clases' => 'required',
            'cantidad_horas' => 'required',
            'alumnos_matriculados' => 'required',
        ]);


        // Validar que el periodo exista
        $periodo = Periodo::where('fecha_inicio', '<=', $request->fecha_inicio_periodo)
            ->where('fecha_fin', '>=', $request->fecha_inicio_periodo)
            ->orderBy('fecha_inicio', 'desc')
            ->first();

        if (!$periodo) {
            return redirect()->back()->with('error', 'El periodo seleccionado no existe');
        }

        $asignatura = Asignatura::find($request->asignatura);

        $docentes = User::whereIn('id', $request->docentes)
            ->get();

        $curso = Curso::create([
            'nombre' => $asignatura->nombre,
            'periodo_id' => $periodo->id,
            'asignatura_id' => $asignatura->id,
            'dias' => implode(',', $request->dias),
            'hora_inicio' => $request->input('hora_inicio'),
            'hora_fin' => $request->input('hora_fin'),
            'cantidad_horas' => $request->input('cantidad_horas'),
            'alumnos_matriculados' => $request->input('alumnos_matriculados'),
            'total_clases_semana' => $request->input('total_clases'),
        ]);


        $curso->docentes()->attach($docentes);
        $delay = now()->addSeconds(5);
        // Notificar a los docentes
        foreach ($docentes as $docente) {
            $docente->notify((new CursoCreadoNotification($curso))->delay($delay));
        }

        if ($request->has('slots')) {
            $slots = [];

            foreach ($request->slots as $slot) {
                $slots[] = [
                    'hora_inicio' => $slot['horaInicio'],
                    'hora_fin' => $slot['horaFin'],
                    'fecha' => $slot['fecha'],
                ];
            }

            $tarea = Tarea::create([
                'tipo_tarea_id' => TipoTarea::where('alias', 'crear_reservas_slots')->first()->id,
                'estado' => 'pendiente',
                'fecha_inicio' => now(),
            ]);

            CrearReservasDesdeSlotsJob::dispatch($curso, $slots, $periodo, $tarea);
        }

        return redirect()->route('cursos.index')->with('success', 'Curso creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Curso $curso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Curso $curso)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Curso $curso)
    {
        //
    }
}
