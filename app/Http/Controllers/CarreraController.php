<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class CarreraController extends Controller
{

    public function index(Request $request)
    {
        $queries = ['search'];

        $carreras = Carrera::orderBy('id', 'desc')
            ->filter($request->only($queries))
            ->get();

        return Inertia::render('Carreras/Index', [
            'carreras' => $carreras,
            'filters' => $request->all($queries)
        ]);
    }


    public function create()
    {
        return Inertia::render('Carreras/Create');
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'nullable',
            'duracion' => 'required',
            'descripcion' => 'required'
        ]);

        Carrera::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'duracion' => $request->duracion,
            'descripcion' => $request->duracion
        ]);

        return Redirect::route("carreras.index")->with('success', 'Carrera Registrada Exitosamente');
    }


    public function show($id)
    {
        //
    }


    public function edit(Carrera $carrera)
    {
        return Inertia::render('Carreras/Edit', [

            'carrera' => [
                'id' => $carrera->id,
                'nombre' => $carrera->nombre,
                'codigo' => $carrera->codigo,
                'duracion' => $carrera->duracion,
                'descripcion' => $carrera->descripcion
            ]

        ]);
    }


    public function update(Request $request, Carrera $carrera)
    {
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'nullable',
            'duracion' => 'required',
            'descripcion' => 'required'
        ]);

        $carrera->update([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'duracion' => $request->duracion,
            'descripcion' => $request->descripcion
        ]);

        return Redirect::route("carreras.index")->with('success', 'Carrera Actualizada Exitosamente');
    }


    public function destroy($id)
    {
        $carrera = Carrera::find($id);

        $carrera->delete();

        return Redirect::route('carreras.index');
    }
}
