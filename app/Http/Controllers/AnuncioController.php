<?php

namespace App\Http\Controllers;

use App\Models\Anuncio;
use App\Models\Clase;
use Illuminate\Http\Request;

class AnuncioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $clase = Clase::find($request->anunciable_id);

        $request->validate([
            'titulo' => 'required',
            'descripcion' => 'nullable',
            'user_id' => 'required',
            'anunciable_id' => 'required'
        ]);

        $descripcionArray = $request->descripcion;

        $textoDescripcion = '';

        if (is_array($descripcionArray)) {
            foreach ($descripcionArray['ops'] as $op) {
                if (isset($op['insert'])) {
                    $textoDescripcion .= $op['insert'];
                }
            }
        } else {
            // Si la descripción no es un array, se asigna tal cual
            $textoDescripcion = $descripcionArray;
        }

        Anuncio::create([
            'titulo' => $request->titulo,
            'descripcion' => $textoDescripcion,
            'user_id' => $request->user_id,
            'anunciable_id' => $request->anunciable_id,
            'anunciable_type' => get_class($clase)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
