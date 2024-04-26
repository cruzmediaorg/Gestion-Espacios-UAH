<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservaRequest;
use App\Http\Resources\EspacioResource;
use App\Http\Resources\ReservaResource;
use App\Models\Equipamiento;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): \Inertia\Response
    {
        $reservas = Reserva::all();

        return Inertia::render('Reservas/Index', [
            'reservas' => ReservaResource::collection($reservas),
            'openDrawer' => false,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): \Inertia\Response
    {
        $espacios = Espacio::all();
        $usuarios = User::all();
        $recursos = Equipamiento::all();

        return Inertia::render('Reservas/Index', [
            'reservas' => ReservaResource::collection(Reserva::all()),
            'openDrawer' => true,
            'espacios' => EspacioResource::collection($espacios),
            'usuarios' => $usuarios,
            'recursos' => $recursos,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservaRequest $request): RedirectResponse
    {
        $horas = explode(' - ', $request->horas);
        $hora_inicio = $horas[0];
        $hora_fin = $horas[1];
        $fecha = Carbon::parse($request->fecha);

        // Verificar que la fecha no sea menor a la actual
        if ($fecha < now()) {
            return redirect()->back()->withErrors(['fecha' => 'La fecha no puede ser menor a la actual']);
        }

        Reserva::create([
            'reservable_id' => $request->reservable_id,
            'reservable_type' => $request->reservable_type,
            'asignado_a' => $request->asignado_a,
            'fecha' => Carbon::parse($request->fecha),
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'comentario' => $request->comentario,
            'type' => $request->tipo_reserva,
        ]);

        return redirect()->route('reservas.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva): \Inertia\Response
    {
        $espacios = Espacio::all();
        $usuarios = User::all();
        $recursos = Equipamiento::all();

        return Inertia::render('Reservas/Index', [
            'reservas' => ReservaResource::collection(Reserva::all()),
            'openDrawer' => true,
            'espacios' => EspacioResource::collection($espacios),
            'usuarios' => $usuarios,
            'reserva' => ReservaResource::make($reserva),
            'recursos' => $recursos,
            'isEdit' => true,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservaRequest $request, Reserva $reserva): RedirectResponse
    {
        $horas = explode(' - ', $request->horas);
        $hora_inicio = $horas[0];
        $hora_fin = $horas[1];
        //sumale 1 dia a la fecha
        $fecha = (Carbon::parse($request->fecha));


        // Verificar que la fecha no sea menor a la actual
        if ($fecha < now()) {
            return redirect()->back()->withErrors(['fecha' => 'La fecha no puede ser menor a la actual']);
        }

        // Verificar si ya hay una reserva en ese horario
        $reservas = Reserva::where('reservable_id', $request->reservable_id)
            ->where('fecha', $fecha)
            ->where('hora_inicio', $hora_inicio)
            ->where('hora_fin', $hora_fin)
            ->get();

        if ($reservas->count() > 0 && $reservas->first()->id !== $reserva->id) {
            return redirect()->back()->withErrors(['fecha' => 'Ya hay una reserva en ese horario']);
        }

        $reserva->update([
            'reservable_id' => $request->reservable_id,
            'reservable_type' => $request->reservable_type,
            'asignado_a' => $request->asignado_a,
            'fecha' => $fecha,
            'hora_inicio' => $hora_inicio,
            'hora_fin' => $hora_fin,
            'comentario' => $request->comentario,
        ]);

        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente');
    }
}
