<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AsignaturaGradoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CursoController;
use App\Http\Controllers\CursoSlotController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\EspacioController;
use App\Http\Controllers\EquipamientoEspacioController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\TipoTareaController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


// Landing page
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
})->name('welcome');

// Sin permisos
Route::get('/sin-permisos', function () {
    abort(401);
})->name('sin-permisos');

Route::middleware(['auth', 'verified'])->group(function () {
    // Logs
    Route::get('/logs', [ActivityLogController::class, '__invoke'])->name('logs');

    // Reservas
    Route::get('/reservas/{reserva}/ver', [ReservaController::class, 'show'])->name('reservas.showView');
    Route::resource('reservas', ReservaController::class)->middleware(['auth', 'verified']);
    Route::get('/reservas/{reserva}/gestionar', [ReservaController::class, 'gestionar'])->name('reservas.gestionar');
    Route::put('/reservas/{reserva}/gestionar', [ReservaController::class, 'cambiarEstado'])->name('reservas.gestionar.store');

    // Calendario
    Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');

    // Notificaciones
    Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notificaciones');
    Route::get('/notificaciones/readed', [NotificationController::class, 'readedNotifications'])->name('notificaciones.leidas');
    Route::post('/notificaciones/{id}', [NotificationController::class, 'toggleRead'])->name('notificaciones.marcar-como-leida');
    Route::post('/notificaciones', [NotificationController::class, 'markAllAsRead'])->name('notificaciones.marcar-todas-como-leidas');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Perfil
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});


Route::prefix('/control')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Control/Index');
    })->name('control');

    // Usuarios
    Route::resource('usuarios', UsuarioController::class);

    // Roles
    Route::resource('roles', RoleController::class);

    // Cursos
    Route::resource('cursos', CursoController::class);
    Route::get('/cursos/{curso}/pdf', [CursoController::class, 'downloadPdf'])->name('cursos.pdf');
    Route::post('/cursos/slots', [CursoSlotController::class, 'store'])->name('cursos.slot.store');
    Route::put('/cursos/slots/{slot}', [CursoSlotController::class, 'update'])->name('cursos.slot.update');
    Route::get('/cursos/{curso}/reservas/generar', [CursoSlotController::class, 'generarReservas'])->name('cursos.reservas.generar');
   Route::delete('/cursos/slots/{slot}', [CursoSlotController::class, 'destroy'])->name('cursos.slot.destroy');

    // Tareas programadas
    Route::get('tareas', [TipoTareaController::class, 'index'])->name('tareas.index');
    Route::get('tareas/{id}/listas', [TipoTareaController::class, 'listas'])->name('tareas.listas');
    Route::get('tareas/{id}/crear', [TipoTareaController::class, 'create'])->name('tareas.create');
    Route::post('tareas/{id}/ejecutar', [TipoTareaController::class, 'ejecutar'])->name('tareas.ejecutar');

    // Grados
    Route::resource('grados', GradoController::class);
    Route::group(['prefix' => 'grados/asignaturas'], function () {
        Route::get('/{id}/edit', [AsignaturaGradoController::class, 'edit'])->name('grados.asignaturas.edit');
        Route::put('/{id}', [AsignaturaGradoController::class, 'update'])->name('grados.asignaturas.update');
        Route::delete('/{id}', [AsignaturaGradoController::class, 'destroy'])->name('grados.asignaturas.destroy');
        Route::post('/', [AsignaturaGradoController::class, 'store'])->name('grados.asignaturas.store');
    });

    // Espacios
    Route::resource('espacios', EspacioController::class);
    Route::group(['prefix' => 'espacios/equipamiento'], function () {
        Route::get('/{id}/edit', [EquipamientoEspacioController::class, 'edit'])->name('espacios.equipamiento.edit');
        Route::put('/{id}', [EquipamientoEspacioController::class, 'update'])->name('espacios.equipamiento.update');
        Route::delete('/{id}', [EquipamientoEspacioController::class, 'destroy'])->name('espacios.equipamiento.destroy');
        Route::post('/', [EquipamientoEspacioController::class, 'store'])->name('espacios.equipamiento.store');
    });
});

require __DIR__ . '/auth.php';
