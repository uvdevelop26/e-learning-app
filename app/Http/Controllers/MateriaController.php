<?php

namespace App\Http\Controllers;

use App\Http\Requests\MateriaRequest;
use App\Models\Carrera;
use App\Models\Materia;
use App\Models\Semestre;
use GuzzleHttp\Psr7\Response;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class MateriaController extends Controller
{

    public function index()
    {
        $materias = Materia::with('semestre.carrera')
            ->orderBy('id', 'desc')
            ->get();

        return Inertia::render('Materias/Index', ['materias' => $materias]);
    }


    public function create()
    {
        $carreras = Carrera::all();
        $semestres = Semestre::all();
        return Inertia::render('Materias/Create', [
            'carreras' => $carreras,
            'semestres' => $semestres
        ]);
    }


    public function store(MateriaRequest $request)
    {
        $path = "";

        if ($request->hasFile('plan_estudio')) {
            $file = $request->file('plan_estudio');
            $extension = $file->getClientOriginalExtension();

            $filename = time() . '.' . $extension;

            $path = $file->storeAs('public/files', $filename);
        }

        Materia::create([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'horas_semanales' => $request->horas_semanales,
            'plan_estudio' => $path,
            'descripcion' => $request->descripcion,
            'semestre_id' => $request->semestre_id
        ]);

        return Redirect::route("materias.index");
    }


    public function show($id)
    {
        //
    }


    public function edit(Materia $materia)
    {
        $carreras = Carrera::all();

        $currentCarrera = Semestre::find($materia->semestre_id)->carrera->id;

        $semestres = Semestre::all();

        return Inertia::render('Materias/Edit', [
            'materia' => [
                'id' => $materia->id,
                'nombre' => $materia->nombre,
                'codigo' => $materia->codigo,
                'horas_semanales' => $materia->horas_semanales,
                'plan_estudio' => $materia->plan_estudio,
                'descripcion' => $materia->descripcion,
                'semestre_id' => $materia->semestre_id
            ],

            'carreras' => $carreras,
            'semestres' => $semestres,
            'currentCarrera' => $currentCarrera
        ]);
    }


    public function update(MateriaRequest $request, Materia $materia)
    {
        $path = $materia->plan_estudio;

        if ($request->hasFile('plan_estudio')) {
            $file = $request->file('plan_estudio');
            $extension = $file->getClientOriginalExtension();

            $filename = time() . '.' . $extension;

            $path = $file->storeAs('public/files', $filename);

            if (File::exists(storage_path("app/{$materia->plan_estudio}"))) {
                File::delete(storage_path("app/{$materia->plan_estudio}"));
            }
        }

        $materia->update([
            'nombre' => $request->nombre,
            'codigo' => $request->codigo,
            'horas_semanales' => $request->horas_semanales,
            'plan_estudio' => $path,
            'descripcion' => $request->descripcion,
            'semestre_id' => $request->semestre_id

        ]);


        return Redirect::route("materias.index");
    }

    public function destroy($id)
    {
        $materia = Materia::find($id);

        if (File::exists(storage_path("app/{$materia->plan_estudio}"))) {
            
            File::delete(storage_path("app/{$materia->plan_estudio}"));
        }

        $materia->delete();

        return Redirect::route("materias.index");

    }

    public function download($id)
    {
        $materia = Materia::findOrFail($id);

        $path = storage_path("app/{$materia->plan_estudio}");

        if (empty($materia->plan_estudio) || !File::exists($path)) {
            abort(404);
        }

        return response()->download($path, 'plan_estudio_' . $materia->nombre . '.pdf');
    }
}
