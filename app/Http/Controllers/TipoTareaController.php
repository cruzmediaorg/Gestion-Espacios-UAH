<?php

namespace App\Http\Controllers;

use App\Models\Tarea;
use App\Models\TipoTarea;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TipoTareaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tiposTareas = TipoTarea::all();

        return Inertia::render('Control/Tareas/Index', [
            'tiposTareas' => $tiposTareas
        ]);
    }

    /**
     * Listas de tareas por tipo
     */
    public function listas($id)
    {
        $tipoTarea = TipoTarea::find($id);
        $tareas = Tarea::where('tipo_tarea_id', $tipoTarea->id)->orderBy('fecha_inicio', 'desc')->get();

        return Inertia::render('Control/Tareas/Listas', [
            'tareas' => $tareas,
            'tipoTarea' => $tipoTarea
        ]);
    }

    /**
     * Crear una nueva tarea
     */
    public function create($id)
    {
        $tipoTarea = TipoTarea::find($id);

        return Inertia::render('Control/Tareas/Create', [
            'tipoTarea' => $tipoTarea
        ]);
    }

    /**
     * Ejecuta una tarea
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */

    public function ejecutar(Request $request, int $id)
    {

        $tipoTarea = TipoTarea::findOrfail($id);

        // Si la tarea requiere parámetros, se validan
        if ($tipoTarea->parametros_requeridos) {
            $request->validate([
                'parametros' => 'required|array',
                'parametros.*' => 'required'
            ]);
        }

        // Se crea la tarea (Para dar seguimiento, trazas, etc...
        $tarea = Tarea::create([
            'tipo_tarea_id' => $tipoTarea->id,
            'fecha_inicio' => now()
        ]);

        // Se determina la clase que se encargará de ejecutar la tarea (IoC)
        $clase = 'App\Jobs\\' . $tipoTarea->clasePHP;

        // Se encola la tarea
        dispatch(new $clase($tarea->id, $request->parametros));

        return redirect()->route('tareas.listas', $tipoTarea->id)->with('success', 'Tarea encolada');
    }
}
