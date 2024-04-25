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
            'comentable_id' => 'required',
            'comentable_type' => 'required',
            'user_id' => 'required'
        ]);

        Comentario::create([
            'contenido' => $request->contenido,
            'comentable_id' => $request->comentable_id,
            'comentable_type' => $request->comentable_type,
            'user_id' => $request->user_id
        ]);
    }


    public function show(Comentario $comentario)
    {
    }

    public function edit(Comentario $comentario)
    {
        //
    }

    public function update(Request $request, Comentario $comentario)
    {

        $request->validate([
            'contenido' => 'required',
            'comentable_id' => 'required',
            'comentable_type' => 'required',
            'user_id' => 'required'
        ]);

        $comentario->update([
            'contenido' => $request->contenido,
            'comentable_id' => $request->comentable_id,
            'comentable_type' => $request->comentable_type,
            'user_id' => $request->user_id
        ]);
    }


    public function destroy($id)
    {
        $comentario = Comentario::find($id);

        $comentario->delete();
    }
}
