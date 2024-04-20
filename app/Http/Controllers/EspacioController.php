<?php

namespace App\Http\Controllers;

use App\Http\Resources\EspacioResource;
use App\Models\Equipamiento;
use App\Models\Espacio;
use App\Models\Localizacion;
use App\Models\TipoEspacio;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EspacioController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $espacios = Espacio::all();
        $tiposEspacios = TipoEspacio::all()->pluck('nombre', 'id');
        $localizaciones = Localizacion::all()->pluck('nombre', 'id');

        return Inertia::render('Control/Espacios/Index', [
            'espacios' => EspacioResource::collection($espacios),
            'tiposEspacios' => $tiposEspacios,
            'localizaciones' => $localizaciones
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Control/Espacios/Form', [
            'isEdit' => false,
            'equipamientos' => Equipamiento::all(),
            'localizaciones' => Localizacion::all(),
            'tiposespacios' => TipoEspacio::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'localizacion_id' => 'required|exists:localizaciones,id',
            'tiposespacios_id' => 'required|exists:tiposEspacios,id',
            'capacidad' => 'required|integer',
        ]);

        Espacio::create($request->all());

        return redirect()->route('espacios.index')->with('success', 'Espacio creado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Espacio $espacio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Espacio $espacio)
    {

        $equipamientos = Equipamiento::all();
        $localizaciones = Localizacion::all();
        $tiposEspacios = TipoEspacio::all();

        return Inertia::render('Control/Espacios/Form', [
            'isEdit' => true,
            'espacio' => EspacioResource::make($espacio),
            'equipamientos' => $equipamientos,
            'localizaciones' => $localizaciones,
            'tiposespacios' => $tiposEspacios
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Espacio $espacio)
    {
        $request->validate([
            'nombre' => 'required',
            'localizacion_id' => 'required|exists:localizaciones,id',
            'tiposespacios_id' => 'required|exists:tiposEspacios,id',
            'capacidad' => 'required|integer',
        ]);

        $espacio->update($request->all());

        return redirect()->route('espacios.index')->with('success', 'Espacio actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Espacio $espacio)
    {
        //
    }
}
