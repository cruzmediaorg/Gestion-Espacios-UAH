<?php

namespace App\Http\Controllers;

use App\Http\Resources\GradoResource;
use App\Models\Asignatura;
use App\Models\AsignaturaGrado;
use App\Models\Grado;
use App\Models\TipoGrado;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AsignaturaGradoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'grado_id' => 'required|exists:grados,id',
        ]);

        AsignaturaGrado::create($request->all());

        return redirect()->route('grados.edit', $request['grado_id'])->with('success', 'Asignatura añadida al grado');
    }

    /**
     * Display the specified resource.
     */
    public function show(AsignaturaGrado $asignaturaGrado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $asignaturaGrado = AsignaturaGrado::find($id);
        $grado = Grado::find($asignaturaGrado->grado_id);

        return Inertia::render('Control/Grados/Form', [
            'isEdit' => true,
            'isAsignaturaGradoEdit' => true,
            'AsignaturaGrado' => $asignaturaGrado,
            'grado' => GradoResource::make($grado),
            'asignaturas' => Asignatura::all(),
            'tiposGrados' => TipoGrado::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'asignatura_id' => 'required|exists:asignaturas,id',
            'grado_id' => 'required|exists:grados,id',
        ]);

        AsignaturaGrado::find($id)->update($request->all());

        return redirect()->route('grados.edit', $validated['grado_id'])->with('success', 'Grado actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $asignaturaGrado = AsignaturaGrado::find($id);
        $grado_id = $asignaturaGrado->grado_id;
        $asignaturaGrado->forceDelete();

        return redirect()->route('grados.edit', $grado_id)->with('success', 'Asignatura eliminada del grado');
    }
}
