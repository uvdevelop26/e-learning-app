<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Unidade;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UnidadeController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        $request->validate([
            'numero' => 'required',
            'tema' => 'required',
            'objetivos' => 'nullable',
        ]);

        Unidade::create([
            'numero' => $request->numero,
            'tema' => $request->tema,
            'objetivos' => $request->objetivos,
            'clase_id' => $request->clase_id
        ]);

        return redirect()->back();;
    }


    public function show($clase, $unidade)
    {

        $unidade = Unidade::findOrFail($unidade);

        $anunciosYtareas = Unidade::with(['anuncios.comentarios.user.alumnos.persona', 'anuncios.materiales', 'tareas'])
            ->findOrFail($unidade->id);

        return Inertia::render('Unidades/Show', [
            'anunciosYtareas' => $anunciosYtareas,
            'clase_id' => $clase
        ]);
    }


    public function update(Request $request, $id)
    {

        $unidade = Unidade::find($id);

        $request->validate([
            'numero' => 'required',
            'tema' => 'required',
            'objetivos' => 'nullable',
        ]);

        $unidade->update([
            'numero' => $request->numero,
            'tema' => $request->tema,
            'objetivos' => $request->objetivos,
            'clase_id' => $request->clase_id
        ]);
    }

    public function destroy($id)
    {
        $unidade = Unidade::find($id);

        $unidade->delete();
    }

    /* public function tareas($id)
    {
        $unidade = Unidade::findOrFail($id);

        $tareas = $unidade->tareas()->get();

        return Inertia::render('Unidades/Tareas', [
            'tareas' => $tareas,
            'unidade_id' => $id
        ]);
    } */
}
