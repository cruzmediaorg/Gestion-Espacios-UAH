<?php

use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\AsignaturaGradoController;
use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\CursoController;
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


Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    } else {
        return redirect()->route('login');
    }
})->name('welcome');



/*
 * Rutas para los usuarios sin permisos
 */
Route::get('/sin-permisos', function () {
    abort(401);
})->name('sin-permisos');

/*
 * Ruta para los logs
 */

Route::get('/logs', [ActivityLogController::class, '__invoke'])->name('logs');

/*
* Rutas para las reservas
*/
Route::resource('reservas', ReservaController::class)->middleware(['auth', 'verified']);

/*
 * Rutas para el calendario
 */

Route::get('/calendario', [CalendarioController::class, 'index'])->name('calendario');
/*
* Rutas para las gestiones de control
*/

/*
     * Rutas para las notificaciones
     */

Route::get('/notificaciones', [NotificationController::class, 'index'])->name('notificaciones');
Route::get('/notificaciones/readed', [NotificationController::class, 'readedNotifications'])->name('notificaciones.leidas');
Route::post('/notificaciones/{id}', [NotificationController::class, 'toggleRead'])->name('notificaciones.marcar-como-leida');
Route::post('/notificaciones', [NotificationController::class, 'markAllAsRead'])->name('notificaciones.marcar-todas-como-leidas');


Route::prefix('/control')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Control/Index');
    })->name('control');

    Route::resource('usuarios', UsuarioController::class);
    Route::resource('roles', RoleController::class);

    /*
     * Rutas para los cursos
     */
    Route::resource('cursos', CursoController::class);

    /*
    Rutas para las tareas
    */
    Route::get('tareas', [TipoTareaController::class, 'index'])->name('tareas.index');
    Route::get('tareas/{id}/listas', [TipoTareaController::class, 'listas'])->name('tareas.listas');
    Route::get('tareas/{id}/crear', [TipoTareaController::class, 'create'])->name('tareas.create');
    Route::post('tareas/{id}/ejecutar', [TipoTareaController::class, 'ejecutar'])->name('tareas.ejecutar');

    /*
    * Rutas para los grados
    */
    Route::resource('grados', GradoController::class);
    Route::group(['prefix' => 'grados/asignaturas'], function () {
        Route::get('/{id}/edit', [AsignaturaGradoController::class, 'edit'])->name('grados.asignaturas.edit');
        Route::put('/{id}', [AsignaturaGradoController::class, 'update'])->name('grados.asignaturas.update');
        Route::delete('/{id}', [AsignaturaGradoController::class, 'destroy'])->name('grados.asignaturas.destroy');
        Route::post('/', [AsignaturaGradoController::class, 'store'])->name('grados.asignaturas.store');
    });

    /*
    * Rutas para los espacios
    */
    Route::resource('espacios', EspacioController::class);
    Route::group(['prefix' => 'espacios/equipamiento'], function () {
        Route::get('/{id}/edit', [EquipamientoEspacioController::class, 'edit'])->name('espacios.equipamiento.edit');
        Route::put('/{id}', [EquipamientoEspacioController::class, 'update'])->name('espacios.equipamiento.update');
        Route::delete('/{id}', [EquipamientoEspacioController::class, 'destroy'])->name('espacios.equipamiento.destroy');
        Route::post('/', [EquipamientoEspacioController::class, 'store'])->name('espacios.equipamiento.store');
    });
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
