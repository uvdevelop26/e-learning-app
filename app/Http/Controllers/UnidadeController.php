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


        /*
        $clase->unidades()->attach($unidade->id); */
    }


    public function show($id)
    {
       
        $unidade = Unidade::find($id);

        return Inertia::render('Unidades/Show', [
            'unidade' => $unidade
        ]);
    }

    /*   public function edit(Unidade $unidade)
    {
        return $unidade;
    } */

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
}
