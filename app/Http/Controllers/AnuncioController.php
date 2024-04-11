<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnuncioRequest;
use App\Models\Anuncio;
use App\Models\Clase;
use App\Models\Materiale;
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
    public function store(AnuncioRequest $request)
    {

        $clase = Clase::find($request->anunciable_id);

        $materiales = $request->url;

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

        $anuncio = Anuncio::create([
            'titulo' => $request->titulo,
            'descripcion' => $textoDescripcion,
            'user_id' => $request->user_id,
            'anunciable_id' => $request->anunciable_id,
            'anunciable_type' => get_class($clase)
        ]);

        if (!empty($materiales)) {

            $path = "";

            foreach ($materiales as $key => $materiale) {
                $extension = $materiale->getClientOriginalExtension();
                $filename = time() . $key . '.' . $extension;
                $path = $materiale->storeAs('public/materiales', $filename);

                Materiale::create([
                    'nombre' => $materiale->getClientOriginalName(),
                    'url' => $path,
                    'anuncio_id' => $anuncio->id
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


    public function update(AnuncioRequest $request, $id)
    {
        $clase = Clase::find($request->anunciable_id);

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

        $anuncio = Anuncio::findOrFail($id);

        $anuncio->update([
            'titulo' => $request->titulo,
            'descripcion' => $textoDescripcion,
            'user_id' => $request->user_id,
            'anunciable_id' => $request->anunciable_id,
            'anunciable_type' => get_class($clase)
        ]);
    }


    public function destroy($id)
    {
        $anuncio = Anuncio::find($id);

        $anuncio->delete();
    }
}
