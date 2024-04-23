<?php

namespace App\Http\Controllers;

use App\Http\Requests\TareaRequest;
use App\Models\Tarea;
use Illuminate\Http\Request;

class TareaController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(TareaRequest $request)
    {
        $instruccionArray = $request->instruccion;

        $textoInstruccion = '';

        if (is_array($instruccionArray)) {
            foreach ($instruccionArray['ops'] as $op) {
                if (isset($op['insert'])) {
                    $textoInstruccion .= $op['insert'];
                }
            }
        } else {
            // Si la descripción no es un array, se asigna tal cual
            $textoInstruccion = $instruccionArray;
        }

        $tarea = Tarea::create([
            'titulo' => $request->titulo,
            'instruccion' => $textoInstruccion,
            'fecha_entrega' => $request->fecha_entrega,
            'hora_entrega' => $request->hora_entrega,
            'puntos' => $request->puntos,
            'unidade_id' => $request->unidade_id
        ]);
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
