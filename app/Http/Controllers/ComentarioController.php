<?php

namespace App\Http\Controllers;

use App\Models\Comentario;
use Illuminate\Http\Request;

class ComentarioController extends Controller
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
            'contenido' => 'required',
            'anuncio_id' => 'required',
            'user_id' => 'required'
        ]);

        Comentario::create([
            'contenido' => $request->contenido,
            'anuncio_id' => $request->anuncio_id,
            'user_id' => $request->user_id
        ]);
    }


    public function show(Comentario $comentario)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function edit(Comentario $comentario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Comentario  $comentario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comentario $comentario)
    {

        $request->validate([
            'contenido' => 'required',
            'anuncio_id' => 'required',
            'user_id' => 'required'
        ]);

        $comentario->update([
            'contenido' => $request->contenido,
            'anuncio_id' => $request->anuncio_id,
            'user_id' => $request->user_id
        ]);
    }

   
    public function destroy($id)
    {
        $comentario = Comentario::find($id);

        $comentario->delete();
    }
}
