<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Clase;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Semestre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class ClaseController extends Controller
{

    public function index()
    {
        $clases = Clase::with('docente.persona', 'materia.semestre.carrera')
            ->orderBy('id', 'desc')
            ->get();
        return Inertia::render('Clases/Index', ['clases' => $clases]);
    }


    public function create()
    {
        $carreras = Carrera::all();
        $semestres = Semestre::all();
        $materias = Materia::all();

        return Inertia::render('Clases/Create', [
            'carreras' => $carreras,
            'semestres' => $semestres,
            'materias' => $materias,
        ]);
    }

    public function store(Request $request)
    {
        $docente_id = Auth::id();

        $request->validate([
            'codigo' => 'required',
            'carrera_id' => 'required',
            'semestre_id' => 'required',
            'materia_id' => 'required'
        ]);

        Clase::create([
            'codigo' => $request->codigo,
            'materia_id' => $request->materia_id,
            'docente_id' => $docente_id,
        ]);

        return Redirect::route("clases.index");
    }


    public function show(Clase $clase)
    {
        $materia = $clase->materia;
        $semestre = Semestre::find($materia->semestre_id);
        $carrera = Carrera::find($semestre->carrera_id);

        return Inertia::render('Clases/Show', [
            'clase' => [
                'id' => $clase->id,
                'codigo' => $clase->codigo,
                'materia_id' => $clase->materia_id,
                'docente_id' => $clase->docente_id,
            ],

            'materia' => $materia,
            'semestre' => $semestre,
            'carrera' => $carrera
        ]);
    }


    public function edit(Clase $clase)
    {
        $carreras = Carrera::all();
        $semestres = Semestre::all();
        $materias = Materia::all();

        $currentSemestre = Materia::find($clase->materia_id)->semestre->id;
        $currentCarrera = Semestre::find($currentSemestre)->carrera->id;

        return Inertia::render('Clases/Edit', [

            'clase' => [
                'id' => $clase->id,
                'codigo' => $clase->codigo,
                'materia_id' => $clase->materia_id,
                'docente_id' => $clase->docente_id,
            ],
            'carreras' => $carreras,
            'semestres' => $semestres,
            'materias' => $materias,
            'currentSemestre' => $currentSemestre,
            'currentCarrera' => $currentCarrera
        ]);
    }


    public function update(Request $request, Clase $clase)
    {
        $docente_id = Auth::id();

        $request->validate([
            'codigo' => 'required',
            'carrera_id' => 'required',
            'semestre_id' => 'required',
            'materia_id' => 'required'
        ]);

        $clase->update([
            'codigo' => $request->codigo,
            'materia_id' => $request->materia_id,
            'docente_id' => $docente_id,
        ]);

        return Redirect::route("clases.index");
    }


    public function destroy($id)
    {
        $clase = Clase::find($id);

        $clase->delete();

        return Redirect::route("clases.index");
    }

    public function showPersonas(Clase $clase)
    {
        $completeAlumnos = Alumno::join('personas', 'alumnos.persona_id', '=', 'personas.id')
            ->select('alumnos.id as alumno_id', 'personas.nombre as nombre_persona', 'personas.apellido as apellido_persona', 'personas.ci_numero as ci_numero_persona')
            ->get();
        $alumnos = $clase->alumnos()->with('persona')->get();
        $docente = Docente::find($clase->docente_id)->persona;

        return Inertia::render('Clases/People', [
            'alumnos' => $alumnos,
            'docente' => $docente,
            'clase' => $clase,
            'completeAlumnos' => $completeAlumnos
        ]);
    }

    public function asignAlumnos(Request $request)
    {

        $request->validate([
            'alumnos' => 'required'
        ]);

        $clase = Clase::find($request->clase);

        $clase->alumnos()->attach($request->alumnos);
    }

    public function revokeAlumno(Request $request)
    {
        $clase = Clase::find($request->clase);

        $clase->alumnos()->detach($request->alumnos);

    }
}
