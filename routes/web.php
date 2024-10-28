<?php

use App\Http\Controllers\CalendarioController;
use App\Http\Controllers\DerivacionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PaisController;
use App\Http\Controllers\EntidadController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\EstadoCivilController;
use App\Http\Controllers\EstadoLaboralController;
use App\Http\Controllers\EstadoMiembrosController;
use App\Http\Controllers\HistorialController;
use App\Http\Controllers\MiembroPrincipalController;
use App\Http\Controllers\MiembroSecundarioController;
use App\Http\Controllers\ParentescoController;
use App\Http\Controllers\PermisoResidenciaController;
use App\Http\Controllers\PermisoTrabajoController;
use App\Http\Controllers\RedCercanaController;
use App\Http\Controllers\TipotarjetaController;

Route::redirect('/', '/login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    Route::get('/paises', [PaisController::class, 'index'])->name('paises.index');
    Route::get('/estadocivil', [EstadoCivilController::class, 'index'])->name('estadocivil.index');
    Route::get('/estadomiembros', [EstadoMiembrosController::class, 'index'])->name('estadomiembros.index');
    Route::get('/entidades', [EntidadController::class, 'index'])->name('entidades.index');
    Route::get('/estadolaboral', [EstadoLaboralController::class, 'index'])->name('estadolaboral.index');
    Route::get('/permisoresidencia', [PermisoResidenciaController::class, 'index'])->name('permisoresidencia.index');
    Route::get('/permisotrabajo', [PermisoTrabajoController::class, 'index'])->name('permisotrabajo.index');
    Route::get('/redcercana', [RedCercanaController::class, 'index'])->name('redcercana.index');
    Route::get('/tipotarjetas', [TipotarjetaController::class, 'index'])->name('tipotarjetas.index');
    Route::get('/parentesco', [ParentescoController::class, 'index'])->name('parentesco.index');
    Route::get('/miembrosprincipales', [MiembroPrincipalController::class, 'index'])->name('miembrosprincipales.index');
    Route::get('/miembrosecundario', [MiembroSecundarioController::class, 'index'])->name('miembrosecundario.index');
    Route::get('/asignaciones', [DerivacionController::class, 'index'])->name('derivaciones.index');
    Route::get('/eventos', [CalendarioController::class, 'index'])->name('eventos.index');
    Route::get('/historial', [HistorialController::class, 'index'])->name('historial.index');
    
});

require __DIR__.'/auth.php';
