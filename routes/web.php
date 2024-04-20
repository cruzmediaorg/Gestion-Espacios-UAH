<?php

use App\Http\Controllers\EspacioController;
use App\Http\Controllers\EquipamientoEspacioController;
use App\Http\Controllers\GradoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReservaController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;



Route::get('/test', function () {
    $espacio = App\Models\Espacio::find(1);

    return $espacio->equipamientos();
})->name('test');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
    return Inertia::render('Welcome');
})->name('welcome');


Route::resource('reservas', ReservaController::class)->middleware(['auth', 'verified']);

Route::prefix('/control')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/', function () {
        return Inertia::render('Control/Index');
    })->name('control');

    Route::resource('usuarios', UsuarioController::class);
    Route::resource('roles', RoleController::class);
    Route::resource('espacios', EspacioController::class);
    Route::resource('grados', GradoController::class);
    Route::get('/espacios/equipamiento/{id}/edit', [EquipamientoEspacioController::class, 'edit'])->name('espacios.equipamiento.edit');
    Route::put('/espacios/equipamiento/{id}', [EquipamientoEspacioController::class, 'update'])->name('espacios.equipamiento.update');
    Route::delete('/espacios/equipamiento/{id}', [EquipamientoEspacioController::class, 'destroy'])->name('espacios.equipamiento.destroy');
    Route::post('/espacios/equipamiento', [EquipamientoEspacioController::class, 'store'])->name('espacios.equipamiento.store');
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
