<?php

namespace App\Http\Controllers;

use App\Http\Resources\GradoResource;
use App\Models\Asignatura;
use App\Models\Grado;
use App\Models\TipoGrado;
use Illuminate\Http\Request;
use Inertia\Inertia;

class GradoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $grados = Grado::all();

        return Inertia::render('Control/Grados/Index', [
            'grados' => GradoResource::collection($grados)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {

        return Inertia::render('Control/Grados/Form', [
            'isEdit' => false,
            'grado' => null,
            'asignaturas' => null,
            'tiposGrados' => TipoGrado::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'tipoGrado_id' => 'required',
        ]);

        $tipoGrado = TipoGrado::find($validated['tipoGrado_id']);

        $prefijo = match ($tipoGrado->nombre) {
            'Grado' => 'GR',
            'Máster' => 'MA',
            'Doctorado' => 'DO',
            default => 'U',
        };

        Grado::create([
            'nombre' => $validated['nombre'],
            'tipoGrado_id' => $validated['tipoGrado_id'],
            'codigo' => $this->generarCodigo($prefijo),
        ]);

        return redirect()->route('grados.index')->with('success', 'Grado creado correctamente');
    }

    /**
     * Genera un código aleatorio con el prefijo 'UAH-PREFIJO'
     */
    private function generarCodigo(string $prefijo): string
    {

        $code = 'UAH-' . $prefijo;
        $code .= '-' . random_int(1000, 9999);

        return $code;
    }

    /**
     * Display the specified resource.
     */
    public function show(Grado $grado)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grado $grado)
    {
        return Inertia::render('Control/Grados/Form', [
            'isEdit' => true,
            'grado' => GradoResource::make($grado),
            'asignaturas' => Asignatura::all(),
            'tiposGrados' => TipoGrado::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Grado $grado)
    {
        $validated = $request->validate([
            'nombre' => 'required',
            'tipoGrado_id' => 'required',
        ]);

        $grado->update([
            'nombre' => $validated['nombre'],
            'tipoGrado_id' => $validated['tipoGrado_id'],
        ]);

        return redirect()->route('grados.index')->with('success', 'Grado actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grado $grado)
    {
        //
    }
}
