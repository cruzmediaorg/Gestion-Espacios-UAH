<?php

namespace App\Http\Controllers;

use App\Http\Resources\EspacioCalendarResource;
use App\Http\Resources\ReservaCalendarResource;
use App\Models\Espacio;
use App\Models\Localizacion;
use App\Models\Reserva;
use App\Models\TipoEspacio;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CalendarioController extends Controller
{
    public function index(Request $request)
    {

        $espacios = Espacio::whereHas('reservas')
            ->get();

        if ($request->has('tipo')) {
            if ($request->tipo !== 'all') {
                $tipo = TipoEspacio::where('nombre', $request->tipo)->first();
                $espacios = $espacios->where('tiposespacios_id', $tipo->id);
            }
        }

        if ($request->has('localizacion')) {
            if ($request->localizacion !== 'all') {
                $localizacion = $request->localizacion;
                $espacios = $espacios->whereIn('localizacion_id', $localizacion);
            }
        }


        $reservas = Reserva::where('reservable_type', 'App\Models\Espacio')
            ->whereIn('reservable_id', $espacios->pluck('id'))
            ->segunUsuario()
            ->get();

        $localizaciones = Localizacion::all()->pluck('nombre', 'id');

        return Inertia::render('Calendario/Index', [
            'espacios' => EspacioCalendarResource::collection($espacios),
            'espaciosRaw' => $espacios,
            'reservas' => ReservaCalendarResource::collection($reservas),
            'tipo' => $request->tipo ?? null,
            'localizacion' => $request->localizacion ?? null,
            'localizaciones' => $localizaciones,
            'clave' => config('services.calendar.sync_key'),
            'usuarios' => auth()->user()->hasRole('administrador') ? User::all() : User::where('id', auth()->id())->get(),
        ]);
    }
}
