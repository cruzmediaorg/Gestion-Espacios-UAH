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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Spatie\LaravelPdf\Facades\Pdf;

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

        return Inertia::render('Control/Cursos/Index', [
            'cursos' => User::find($request->user()->id)->cursos->load(['asignatura', 'periodo'])->loadCount('docentes'),
            'periodos' => Periodo::all()->pluck('nombre', 'id'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $docentes = User::where('tipo', 'responsable')->orderBy('name')->get()->map(function ($user) {
            return [
                'id' => $user->id,
                'name' => $user->name,
                'label' => auth()->user()->id == $user->id ? $user->name . ' (Tú)' : $user->name,
            ];
        });

        // Ordenar y agregar el usuario actual al principio
        return Inertia::render('Control/Cursos/Create', [
            'periodos' => Periodo::all()->pluck('nombre', 'id'),
            'docentes' => $docentes->sortBy('label')->values()->all(),
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
            'alumnos_matriculados' => $request->input('alumnos_matriculados'),
            'total_clases_curso' => $request->input('total_clases'),
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
                $curso->slots()->create([
                    'hora_inicio' => $slot['horaInicio'],
                    'hora_fin' => $slot['horaFin'],
                    'dia' => Carbon::parse($slot['fecha']),
                ]);
            }

            $tipoTarea = TipoTarea::where('alias', 'crear_reservas_sin_slots')->first();
            $claseTipoTarea = 'App\Jobs\\' . $tipoTarea->clasePHP;

            $tarea = Tarea::create([
                'tipo_tarea_id' => $tipoTarea->id,
                'estado' => 'pendiente',
                'fecha_inicio' => now(),
            ]);

            //Undefined array key "cursos"
            $arrayCursos = [
                'cursos' => $curso->id,
            ];

            dispatch(new $claseTipoTarea($tarea->id, $arrayCursos));
        }

        return redirect()->route('cursos.index')->with('success', 'Curso creado con éxito');
    }

    /**
     * Display the specified resource.
     */
    public function show(Curso $curso)
    {
        return Inertia::render('Control/Cursos/View', [
            'curso' => $curso->load(['asignatura', 'periodo', 'docentes','periodo','slots.reservas']),
        ]);
    }

    /**
     * Download PDF
     */

    public function downloadPdf(Curso $curso)
    {
        $curso = Curso::with(['reservas', 'docentes', 'periodo'])->find($curso->id);

        return Pdf::view('pdf.horarios', ['curso' => $curso])->format('a4')->name('horario.pdf');

    }
}
