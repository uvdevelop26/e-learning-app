<?php

use App\Http\Controllers\AdministradoreController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\UnidadeController;
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


//docentes
Route::controller(DocenteController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('docentes', 'index')->name('docentes.index');
    Route::get('docentes/create', 'create')->name('docentes.create');
    Route::post('docentes', 'store')->name('docentes.store');
    Route::get('docentes/{docente}/edit', 'edit')->name('docentes.edit');
    Route::put('docentes/{docente}', 'update')->name('docentes.update');
    Route::delete('docentes/{docente}', 'destroy')->name('docentes.destroy');
});

//alumnos
Route::controller(AlumnoController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('alumnos', 'index')->name('alumnos.index');
    Route::get('alumnos/create', 'create')->name('alumnos.create');
    Route::post('alumnos', 'store')->name('alumnos.store');
    Route::get('alumnos/{alumno}/edit', 'edit')->name('alumnos.edit');
    Route::put('alumnos/{alumno}', 'update')->name('alumnos.update');
    Route::delete('alumnos/{alumno}', 'destroy')->name('alumnos.destroy');
});

//Administradores
Route::controller(AdministradoreController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('administradores', 'index')->name('administradores.index');
    Route::get('administradores/create', 'create')->name('administradores.create');
    Route::post('administradores', 'store')->name('administradores.store');
    Route::get('administradores/{administradore}/edit', 'edit')->name('administradores.edit');
    Route::put('administradores/{administradore}', 'update')->name('administradores.update');
    Route::delete('administradores/{administradore}', 'destroy')->name('administradores.destroy');
});

//Carreras
Route::controller(CarreraController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('carreras', 'index')->name('carreras.index');
    Route::get('carreras/create', 'create')->name('carreras.create');
    Route::post('carreras', 'store')->name('carreras.store');
    Route::get('carreras/{carrera}/edit', 'edit')->name('carreras.edit');
    Route::put('carreras/{carrera}', 'update')->name('carreras.update');
    Route::delete('carreras/{carrera}', 'destroy')->name('carreras.destroy');
});

//semestres
Route::controller(SemestreController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('semestres', 'index')->name('semestres.index');
    Route::get('semestres/create', 'create')->name('semestres.create');
    Route::post('semestres', 'store')->name('semestres.store');
    Route::get('semestres/{semestre}/edit', 'edit')->name('semestres.edit');
    Route::put('semestres/{semestre}', 'update')->name('semestres.update');
    Route::delete('semestres/{semestre}', 'destroy')->name('semestres.destroy');
});

//materias
Route::controller(MateriaController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('materias', 'index')->name('materias.index');
    Route::get('materias/create', 'create')->name('materias.create');
    Route::post('materias', 'store')->name('materias.store');
    Route::get('materias/{materia}/edit', 'edit')->name('materias.edit');
    Route::put('materias/{materia}', 'update')->name('materias.update');
    Route::delete('materias/{materia}', 'destroy')->name('materias.destroy');
    Route::get('download/{id}', 'download')->name('materias.download');
});

//clases
Route::controller(ClaseController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('clases', 'index')->name('clases.index');
    Route::get('clases/create', 'create')->name('clases.create');
    Route::post('clases', 'store')->name('clases.store');
    Route::get('clases/{clase}/edit', 'edit')->name('clases.edit');
    Route::put('clases/{clase}', 'update')->name('clases.update');
    Route::delete('clases/{clase}', 'destroy')->name('clases.destroy');
    Route::get("clases/{clase}", 'show')->name("clases.show");
    Route::get("clases/{clase}/personas", 'showPersonas')->name("clases.showPersonas");
    Route::post('clases/asign-alumnos', 'asignAlumnos')->name('clases.asignAlumnos');
    Route::delete('clases/revoke-alumnos/{clase}', 'revokeAlumno')->name('clases.revokeAlumno');
});


//anuncios
Route::controller(AnuncioController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('anuncios', 'store')->name('anuncios.store');
});

//unidades
Route::controller(UnidadeController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('unidades', 'store')->name('unidades.store');
    Route::get("unidades/{unidad}", 'show')->name("unidades.show");
});
