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
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class MateriaController extends Controller
{

    public function index(Request $request)
    {
        $queries = ['search', 'page'];

        $materias = Materia::with('semestre.carrera')
            ->orderBy('id', 'desc')
            ->filter($request->only($queries))
            ->paginate(6);

        return Inertia::render('Materias/Index', [
            'materias' => $materias,
            'filters' => $request->all($queries)
        ]);
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

        return Redirect::route("materias.index")->with('success', 'Materia Registrada Exitosamente');
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


        return Redirect::route("materias.index")->with('success', 'Materia Actualizada Exitosamente');
    }

    public function destroy($id)
    {
        $materia = Materia::find($id);

        if (File::exists(storage_path("app/{$materia->plan_estudio}"))) {

            File::delete(storage_path("app/{$materia->plan_estudio}"));
        }

        $materia->delete();

        return Redirect::route("materias.index")->with('success', 'Materia Eliminada Exitosamente');
    }

    public function download($id)
    {
        $materia = Materia::findOrFail($id);

        $path = storage_path("app/{$materia->plan_estudio}");

        if (empty($materia->plan_estudio) || !File::exists($path)) {
            abort(404);
        }

        return response()->download($path, 'plan_estudio_' . $materia->nombre);
    }

    public function pdf(Request $request)
    {
        $queries = ['search'];

        $materias = Materia::with('semestre.carrera')
            ->orderBy('semestre_id', 'desc')
            ->filter($request->only($queries))
            ->get();
        $currentDate = Carbon::now()->format('d/m/Y');

        $userEmail = Auth::user()->email;

        $pdf = Pdf::loadView('pdf.materias', compact('materias', 'currentDate', 'userEmail'));

        return $pdf->stream('lista_materias.pdf');
    }
}
