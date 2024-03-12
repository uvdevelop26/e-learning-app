<?php

use App\Http\Controllers\AdministradoreController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\DocenteController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});



Route::controller(DocenteController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('docentes', 'index')->name('docentes.index');
    Route::get('docentes/create', 'create')->name('docentes.create');
    Route::post('docentes', 'store')->name('docentes.store');
    Route::get('docentes/{docente}/edit', 'edit')->name('docentes.edit');
    Route::put('docentes/{docente}', 'update')->name('docentes.update');
    Route::delete('docentes/{docente}', 'destroy')->name('docentes.destroy');
});

Route::controller(AdministradoreController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('administradores', 'index')->name('administradores.index');
    Route::get('administradores/create', 'create')->name('administradores.create');
    Route::post('administradores', 'store')->name('administradores.store');
    Route::get('administradores/{administradore}/edit', 'edit')->name('administradores.edit');
    Route::put('administradores/{administradore}', 'update')->name('administradores.update');
    Route::delete('administradores/{administradore}', 'destroy')->name('administradores.destroy');
});

Route::controller(CarreraController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('carreras', 'index')->name('carreras.index');
});
