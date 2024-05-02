<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntregaRequest;
use App\Models\Entrega;
use App\Models\MaterialeTarea;
use Illuminate\Http\Request;

class EntregaController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(EntregaRequest $request)
    {
        $materiales = $request->url;

        $entrega = Entrega::create([
            'completado' => $request->completado,
            'puntaje' => $request->puntaje,
            'tarea_id' => $request->tarea_id,
            'user_id' => $request->user_id
        ]);

        if (!empty($materiales)) {

            $path = "";

            foreach ($materiales as $key => $materiale) {
                $extension = $materiale->getClientOriginalExtension();
                $filename = time() . $key . '.' . $extension;
                $path = $materiale->storeAs('public/tareas', $filename);

                MaterialeTarea::create([
                    'nombre' => $materiale->getClientOriginalName(),
                    'url' => $path,
                    'materiable_id' => $entrega->id,
                    'materiable_type' => $request->materiable_type
                ]);
            }
        }
    }


    public function show($id)
    {
        //
    }


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
