<?php

namespace App\Http\Controllers;

use App\Models\Curso;
use App\Models\Periodo;
use App\Models\User;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
