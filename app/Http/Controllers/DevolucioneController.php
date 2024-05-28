<?php

namespace App\Http\Controllers;

use App\Http\Requests\DevolucioneRequest;
use App\Models\Devolucione;
use App\Models\Entrega;
use App\Models\MaterialeTarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DevolucioneController extends Controller
{

    public function store(DevolucioneRequest $request)
    {
        $materiales = $request->url;
        //previous devoluciones needs to be deleted
        $devoluciones = Entrega::find($request->entrega_id)
            ->devoluciones()
            ->get();

        if (!empty($devoluciones)) {

            foreach ($devoluciones as $devolucion) {
                $devolucionMat = $devolucion->materiales;

                if (!empty($devolucionMat)) {
                    foreach ($devolucionMat as $key => $materiale) {
                        Storage::delete($materiale->url);
                    }
                }
                $devolucion->delete();
            }
        }

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
            'puntos' => $request->puntos,
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
    }


    public function destroy($id)
    {
        $devolucione = Devolucione::find($id);

        $materiales = $devolucione->materiales;

        $devolucione->delete();

        if (!empty($materiales)) {
            foreach ($materiales as $key => $materiale) {
                Storage::delete($materiale->url);
            }
        }
    }
}
