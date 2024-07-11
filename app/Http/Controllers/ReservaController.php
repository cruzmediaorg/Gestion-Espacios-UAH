<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservaRequest;
use App\Http\Resources\EspacioResource;
use App\Http\Resources\ReservaResource;
use App\Models\Equipamiento;
use App\Models\Espacio;
use App\Models\Reserva;
use App\Models\User;
use App\Notifications\SuccessNotification;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ReservaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): Response
    {

        return Inertia::render('Reservas/Index', [
            'reservas' => ReservaResource::collection(Reserva::segunUsuario()
                ->orderBy('created_at', 'desc')
                ->get()),
            'openDrawer' => false,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('Reservas/Index', [
            'reservas' => ReservaResource::collection(Reserva::segunUsuario()
                ->orderBy('created_at', 'desc')
                ->get()),
            'openDrawer' => true,
            'espacios' => EspacioResource::collection(Espacio::all()),
            'usuarios' => User::segunUsuario()->get(),
            'recursos' => Equipamiento::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservaRequest $request): RedirectResponse
    {
        //        $horas = explode(' - ', $request->horas);
        $hora_inicio = $request->hora_inicio;
        $hora_fin = $request->hora_fin;
        $fecha = Carbon::parse($request->fecha);

        // Verificar que la fecha no sea menor a la actual
        if ($fecha < now()) {
            return redirect()->back()->withErrors(['fecha' => 'La fecha no puede ser menor a la actual']);
        }

        if ($hora_inicio >= $hora_fin) {
            return redirect()->back()->withErrors(['hora_inicio' => 'La hora de inicio debe ser menor a la hora de fin']);
        }

        // Verificar si ya hay una reserva en ese horario para ese espacio (incluyendo solapamiento de horas)
        // Por ejemplo si hay una reserva de 8 a 10 y se intenta reservar de 9 a 11, no se permitirá
        $reservas = Reserva::where('reservable_id', $request->reservable_id)
            ->where('reservable_type', $request->reservable_type)
            ->whereNull('fecha_cancelacion')
            ->whereNull('fecha_rechazo')
            ->where('fecha', $fecha)
            ->where('hora_inicio', '<', $hora_fin)
            ->where('hora_fin', '>', $hora_inicio)
            ->get();

        if ($reservas->count() > 0) {
            return redirect()->back()->withErrors(['fecha' => 'Ya hay una reserva en ese horario']);
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

        return redirect()->route('reservas.index')->with('success', 'Reserva creada correctamente');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reserva $reserva): Response
    {
        return Inertia::render('Reservas/Index', [
            'reservas' => ReservaResource::collection(Reserva::segunUsuario()
                ->orderBy('created_at', 'desc')
                ->get()),
            'openDrawer' => true,
            'espacios' => EspacioResource::collection(Espacio::all()),
            'usuarios' => User::segunUsuario()->get(),
            'reserva' => ReservaResource::make($reserva),
            'recursos' => Equipamiento::all(),
            'isEdit' => true,
        ]);
    }

    /**
     * Gestiona la aprobación/cancelación, estado de una reserva
     */
    public function gestionar(Reserva $reserva): Response
    {
        return Inertia::render('Reservas/Index', [
            'reservas' => ReservaResource::collection(Reserva::segunUsuario()
                ->orderBy('created_at', 'desc')
                ->get()),
            'reserva' => ReservaResource::make($reserva),
            'openGestionarDialog' => true,
            'openDrawer' => false,
        ]);
    }

    /**
     * Cambiar estado de la reserva
     */
    public function cambiarEstado(Reserva $reserva, Request $request)
    {
        $request->validate([
            'estado' => 'required',
        ]);

        match ($request->estado) {
            'aprobada' => $reserva->update(['fecha_aprobacion' => now(), 'fecha_rechazo' => null, 'fecha_cancelacion' => null]),
            'cancelada' => $reserva->update(['fecha_cancelacion' => now(), 'fecha_aprobacion' => null, 'fecha_rechazo' => null, 'cancelado_por' => auth()->id()]),
            'rechazada' => $reserva->update(['fecha_rechazo' => now(), 'fecha_aprobacion' => null, 'fecha_cancelacion' => null]),
            default => $reserva->update(['fecha_aprobacion' => null, 'fecha_rechazo' => null, 'fecha_cancelacion' => null]),
        };

        // Notificar al usuario que se actualizó el estado de la reserva
        $user = User::find($reserva->asignado_a);
        $user->notify(new SuccessNotification('Se ha actualizado el estado de la reserva de ' . $reserva->fecha . ' de ' . $reserva->hora_inicio . ' a ' . $reserva->hora_fin . ' en ' . $reserva->reservable->nombre . ' a ' . strtoupper($request->estado)));

        return redirect()->route('reservas.index')->with('success', 'Estado de la reserva actualizado correctamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservaRequest $request, Reserva $reserva): RedirectResponse
    {
        $hora_inicio = $request->hora_inicio;
        $hora_fin = $request->hora_fin;
        $fecha = (Carbon::parse($request->fecha));

        // Verificar que la fecha no sea menor a la actual
        if ($fecha < now()) {
            return redirect()->back()->withErrors(['fecha' => 'La fecha no puede ser menor a la actual']);
        }

        if ($hora_inicio >= $hora_fin) {
            return redirect()->back()->withErrors(['hora_inicio' => 'La hora de inicio debe ser menor a la hora de fin']);
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
            'type' => $request->tipo_reserva,
            'comentario' => $request->comentario,
        ]);

        // Notificar al usuario que se actualizó la reserva
        $user = User::find($request->asignado_a);
        $user->notify(new SuccessNotification('Se ha actualizado la reserva de ' . $reserva->fecha . ' de ' . $reserva->hora_inicio . ' a ' . $reserva->hora_fin . ' en ' . $reserva->reservable->nombre));

        // Eliminar la fecha de aprobación si se actualiza la reserva
        if ($reserva->fecha_aprobacion != null) {
            $reserva->update(['fecha_aprobacion' => null]);

            // Notificar al usuario que se eliminó la fecha de aprobación
            $user->notify(new SuccessNotification('Se ha actualizado la reserva de ' . $reserva->fecha . ' de ' . $reserva->hora_inicio . ' a ' . $reserva->hora_fin . ' en ' . $reserva->reservable->nombre . ' y su nuevo estado es Pendiente'));
        }



        return redirect()->route('reservas.index')->with('success', 'Reserva actualizada correctamente');
    }

    public function show(Reserva $reserva)
    {

        return Inertia::render('Reservas/Show', [
            'reserva' => $reserva,
        ]);
    }

}
