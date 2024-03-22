<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SemestreController extends Controller
{

    public function index(Request $request)
    {
        $queries = ['search'];

        $semestres = Semestre::with('carrera')
            ->orderBy('carrera_id', 'desc')
            ->filter($request->only($queries))
            ->get();

        return Inertia::render('Semestres/Index', [
            'semestres' => $semestres,
            'filters' => $request->all($queries)
        ]);
    }


    public function create()
    {
        $carreras = Carrera::all();

        return Inertia::render('Semestres/Create', ['carreras' => $carreras]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'descripcion' => 'required',
            'carrera_id' => 'required'
        ]);

        Semestre::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'carrera_id' => $request->carrera_id
        ]);

        return Redirect::route("semestres.index");
    }


    public function show($id)
    {
    }


    public function edit(Semestre $semestre)
    {
        $carreras = Carrera::all();

        return Inertia::render('Semestres/Edit', [
            'semestre' => [
                'id' => $semestre->id,
                'nombre' => $semestre->nombre,
                'codigo' => $semestre->codigo,
                'descripcion' => $semestre->descripcion,
                'carrera_id' => $semestre->carrera_id
            ],

            'carreras' => $carreras
        ]);
    }


    public function update(Request $request, Semestre $semestre)
    {
        $request->validate([
            'nombre' => 'required',
            'codigo' => 'required',
            'descripcion' => 'required',      
            'carrera_id' => 'required'
        ]);

        $semestre->update([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'descripcion' => $request->descripcion,
            'carrera_id' => $request->carrera_id
        ]);

        return Redirect::route("semestres.index");
    }

    
    public function destroy($id)
    {
        $semestre = Semestre::find($id);

        $semestre->delete();

        return Redirect::route("semestres.index");

    }
}
