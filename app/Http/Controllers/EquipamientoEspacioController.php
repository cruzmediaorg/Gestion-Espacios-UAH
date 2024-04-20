<?php

namespace App\Http\Controllers;

use App\Http\Resources\EquipamientoEspacioResource;
use App\Http\Resources\EspacioResource;
use App\Models\Equipamiento;
use App\Models\Espacio;
use App\Models\EquipamientoEspacio;
use App\Models\Localizacion;
use App\Models\TipoEspacio;
use Illuminate\Http\Request;
use Inertia\Inertia;

class EquipamientoEspacioController extends Controller
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
            'cantidad' => 'required|integer',
            'equipamiento_id' => 'required|exists:equipamientos,id',
            'espacio_id' => 'required|exists:espacios,id',
        ]);

        EquipamientoEspacio::create($request->all());

        return redirect()->route('espacios.edit', $request['espacio_id'])->with('success', 'Equipamiento añadido correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(EquipamientoEspacio $EquipamientoEspacio)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $EquipamientoEspacio = EquipamientoEspacio::find($id);
        $equipamientos = Equipamiento::all();
        $localizaciones = Localizacion::all();
        $tiposEspacios = TipoEspacio::all();
        $espacio = Espacio::find($EquipamientoEspacio->espacio_id);

        return Inertia::render('Control/Espacios/Form', [
            'EquipamientoEspacio' => EquipamientoEspacioResource::make($EquipamientoEspacio),
            'isEquipamientoDialogOpen' => true,
            'isEquipamientoEspacioEdit' => true,
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
    public function update(Request $request, $id)
    {
        $request->validate([
            'cantidad' => 'required|integer',
        ]);

        $EquipamientoEspacio = EquipamientoEspacio::find($id);
        $EquipamientoEspacio->update([
            'cantidad' => $request['cantidad'],
        ]);

        return redirect()->route('espacios.edit', $EquipamientoEspacio->espacio_id)->with('success', 'Equipamiento actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(EquipamientoEspacio $EquipamientoEspacio)
    {
        //
    }
}
