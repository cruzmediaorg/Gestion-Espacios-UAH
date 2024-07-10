<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {

        $user = Auth::user();

        return Inertia::render('Dashboard', [
            'reservasRecientes' => $user->reservasPasadas()->take(5)->get(),
            'proximasReservas' => $user->reservasProximas()->take(5)->get(),
            'notificacionesSinLeer' => $user->unreadNotifications()->count(),
        ]);
    }
}
