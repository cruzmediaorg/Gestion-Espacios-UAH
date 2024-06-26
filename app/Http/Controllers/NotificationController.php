<?php

namespace App\Http\Controllers;

use App\Http\Resources\NotificationResource;
use Auth;
use Illuminate\Http\Request;
use Inertia\Inertia;

class NotificationController extends Controller
{
    public function index()
    {
        return Inertia::render('Control/Notificaciones/Index', [
            'notifications' => Auth::user()->unreadNotifications()->get()
        ]);
    }

    public function readedNotifications()
    {
        return Inertia::render('Control/Notificaciones/Index', [
            'notifications' => Auth::user()->readNotifications()->get()
        ]);
    }

    public function toggleRead(Request $request)
    {
        $notification = auth()->user()->notifications()->where('id', $request->id)->first();
        if ($notification->read_at) {
            $notification->markAsUnread();

            return redirect()->back()->with('success', 'Notificación marcada como no leída');
        } else {
            $notification->markAsRead();

            return redirect()->back()->with('success', 'Notificación marcada como leída');
        }
    }

    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications()->update(['read_at' => now()]);

        return redirect()->back()->with('success', 'Notificaciones marcadas como leídas');
    }
}
