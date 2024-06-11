<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Inertia\Response;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): Response
    {
        return Inertia::render('Auth/Login', [
            'canResetPassword' => Route::has('password.request'),
            'status' => session('status'),
        ]);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $user = Auth::guard('web')->attempt($request->only('sid', 'password'), $request->boolean('remember'));

        if (!$user) {
            return back()->withErrors([
                'sid' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
            ]);
        }


        $user = Auth::guard('web')->user();

        activity()
            ->causedBy($user)
            ->withProperties(['ip' => $request->ip(), 'user_agent' => $request->userAgent(), 'session_id' => $request->session()->getId()])
            ->tap(fn ($activity) => $activity->log_name = 'login')
            ->log('El usuario ' . $user->sid . ' ha iniciado sesión.');

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
