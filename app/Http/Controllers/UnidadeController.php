<?php

namespace App\Http\Controllers;

use App\Models\Clase;
use App\Models\Unidade;
use Illuminate\Http\Request;

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
        $clase = Clase::find($request->clase);

        $request->validate([
            'numero' => 'required',
            'tema' => 'required',
            'objetivos' => 'nullable'
        ]);

        $unidade = Unidade::create([
            'numero' => $request->numero,
            'tema' => $request->tema,
            'objetivos' => $request->objetivos
        ]);

        $clase->unidades()->attach($unidade->id);

    }

    
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
