<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevolucioneRequest;
use App\Models\Devolucione;
use App\Models\Entrega;
use App\Models\MaterialeTarea;
use Illuminate\Http\Request;

class DevolucioneController extends Controller
{

    public function index()
    {
        //
    }


    public function create()
    {
        //
    }


    public function store(DevolucioneRequest $request)
    {
        $materiales = $request->url;
        $puntaje = $request->puntaje;

        $recomendacionArray = $request->recomendacion;

        $textRecomendacion = '';

        if (is_array($recomendacionArray)) {
            foreach ($recomendacionArray['ops'] as $op) {
                if (isset($op['insert'])) {
                    $textRecomendacion .= $op['insert'];
                }
            }
        } else {
            // Si la descripción no es un array, se asigna tal cual
            $textRecomendacion = $recomendacionArray;
        }

        $devolucione = Devolucione::create([
            'recomendacion' => $request->recomendacion,
            'devuelto' => $request->devuelto,
            'entrega_id' => $request->entrega_id
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
                    'materiable_id' => $devolucione->id,
                    'materiable_type' => $request->materiable_type
                ]);
            }
        }

        if(!empty($puntaje)){
            $entrega = Entrega::find($request->entrega_id);
            $entrega->update([
                'puntaje' => $request->puntaje
            ]);
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

 
    public function update(Request $request, $id)
    {
        //
    }


    public function destroy($id)
    {
        $devolucione = Devolucione::find($id);
        $entrega = Entrega::find($devolucione->entrega_id);

        $entrega->update([
            'puntaje' => null
        ]);
        
        $devolucione->delete();
    }
}
