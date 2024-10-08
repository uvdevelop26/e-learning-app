<?php

use App\Http\Controllers\AcumulativoController;
use App\Http\Controllers\AdministradoreController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\AnuncioController;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\ClaseController;
use App\Http\Controllers\ComentarioController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DevolucioneController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\MaterialeController;
use App\Http\Controllers\MaterialeTareaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SemestreController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UnidadeController;
use App\Models\MaterialeTarea;
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
    return Inertia::render('Auth/Login');
});

Route::controller(ProfileController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('/user/profile', 'show')->name('profile.show');
    Route::put('/profile', 'update' )->name('profile.update');
});


Route::controller(DashboardController::class)
    ->middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified',])
    ->group(function () {
        Route::get('/dashboard', 'index')->name('dashboard');
        Route::get('/dashboard/users', 'users')->name('dashboard.users');
        Route::get('/dashboard/menuData', 'menuData')->name('dashboard.menuData');
    });

//docentes
Route::controller(DocenteController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('docentes', 'index')->name('docentes.index');
    Route::get('docentes/create', 'create')->name('docentes.create');
    Route::post('docentes', 'store')->name('docentes.store');
    Route::get('docentes/{docente}/edit', 'edit')->name('docentes.edit');
    Route::put('docentes/{docente}', 'update')->name('docentes.update');
    Route::delete('docentes/{docente}', 'destroy')->name('docentes.destroy');
    Route::get('docentes/pdf', 'pdf')->name('docentes.pdf');
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
    Route::get('administradores/pdf', 'pdf')->name('administradores.pdf');
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
    Route::get('semestres/pdf', 'pdf')->name('semestres.pdf');
});

//materias
Route::controller(MateriaController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('materias', 'index')->name('materias.index');
    Route::get('materias/create', 'create')->name('materias.create');
    Route::post('materias', 'store')->name('materias.store');
    Route::get('materias/{materia}/edit', 'edit')->name('materias.edit');
    Route::put('materias/{materia}', 'update')->name('materias.update');
    Route::delete('materias/{materia}', 'destroy')->name('materias.destroy');
    Route::get('materias/download/{id}', 'download')->name('materias.download');
    Route::get('materias/pdf', 'pdf')->name('materias.pdf');
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
    Route::get('clases/{clase}/acumulativos', 'acumulativos')->name('clases.acumulativos');
    Route::get('clases/{clase}/pdf', 'pdf')->name('clases.pdf');


    Route::prefix('clases/{clase}/unidades')->controller(UnidadeController::class)->group(function () {
        Route::get('{unidad}', 'show')->name('clases.unidades.show');
    });

    Route::prefix('clases/{clase}/unidades/{unidad}/tareas')->controller(TareaController::class)->group(function () {
        Route::get('{tarea}', 'show')->name('clases.unidades.tareas.show');
    });

    Route::prefix('clases/{clase}/unidades/{unidad}/tareas/{tarea}')->controller(EntregaController::class)->group(function () {
        Route::get('entregas', 'show')->name('clases.unidades.tareas.entregas.show');
    });

    Route::prefix('clases/{clase}/acumulativos')->controller(AcumulativoController::class)->group(function () {
        Route::get('{unidad}', 'index')->name('clases.unidades.acumulativos.index');
        Route::get('{unidad}/pdf', 'pdf')->name('clases.unidades.acumulativos.pdf');
    });
});


//anuncios
Route::controller(AnuncioController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('anuncios', 'store')->name('anuncios.store');
    Route::put('anuncios/{anuncio}', 'update')->name('anuncios.update');
    Route::delete('anuncios/{anuncio}', 'destroy')->name('anuncios.destroy');
});

//unidades
Route::controller(UnidadeController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('unidades', 'store')->name('unidades.store');
    Route::get('unidades/{unidad}/edit', 'edit')->name('unidades.edit');
    Route::put('unidades/{unidad}', 'update')->name('unidades.update');
    Route::delete('unidades/{unidad}', 'destroy')->name('unidades.destroy');
});

//comentarios
Route::controller(ComentarioController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('comentarios', 'store')->name('comentarios.store');
    Route::put('comentarios/{comentario}', 'update')->name('comentarios.update');
    Route::delete('comentarios/{comentario}', 'destroy')->name('comentarios.destroy');
});

//materiales
Route::controller(MaterialeController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('materiales/download/{id}', 'download')->name('materiales.download');
});

//Materiales Tareas
Route::controller(MaterialeTareaController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::get('materialeTareas/download/{id}', 'download')->name('materialeTareas.download');
});

//tareas
Route::controller(TareaController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('tareas', 'store')->name('tareas.store');
    Route::put('tareas/{tarea}', 'update')->name('tareas.update');
    Route::delete('tareas/{tarea}', 'destroy')->name('tareas.destroy');
});

//entregas
Route::controller(EntregaController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('entregas', 'store')->name('entregas.store');
    Route::put('entregas/{entrega}', 'update')->name('entregas.update');
});

//devoluciones
Route::controller(DevolucioneController::class)->middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::post('devoluciones', 'store')->name('devoluciones.store');
    Route::delete('devoluciones/{devolucione}', 'destroy')->name('devoluciones.destroy');
});
