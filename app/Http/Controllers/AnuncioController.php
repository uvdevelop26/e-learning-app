<?php

namespace App\Http\Controllers;

use App\Http\Requests\AnuncioRequest;
use App\Models\Anuncio;
use App\Models\Clase;
use App\Models\Materiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

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
            'anunciable_type' => $request->anunciable_type
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
        $anuncio = Anuncio::findOrFail($id);

        //  $clase = Clase::find($request->anunciable_id);

        $descripcionArray = $request->descripcion;

        $textoDescripcion = '';

        if (is_array($descripcionArray)) {
            foreach ($descripcionArray['ops'] as $op) {
                if (isset($op['insert'])) {
                    $textoDescripcion .= $op['insert'];
                }
            }
        } else {

            $textoDescripcion = $descripcionArray;
        }

        $anuncio->update([
            'titulo' => $request->titulo,
            'descripcion' => $textoDescripcion,
            'user_id' => $request->user_id,
            'anunciable_id' => $request->anunciable_id,
            'anunciable_type' => $request->anunciable_type,
        ]);

        /* the user has deleted all the all files and has'nt added new ones */
        if (empty($request->url) && empty($request->nombre)) {
            $materiales = $anuncio->materiales()->get();

            foreach ($materiales as $key => $materiale) {
                Storage::delete($materiale->url);
            }

            $anuncio->materiales()->delete();

            /* the user has deleted some of the old files but has'nt added new ones */
        } elseif (empty($request->url) && !empty($request->nombre)) {

            /* obtener y eliminar  los materiales eliminados */

            $oldMateriales = $request->nombre;
            $currentMateriales = $anuncio->materiales()->get();

            $newMaterialesIds = collect($oldMateriales)->pluck('id')->toArray();

            $deletedElements = [];
            foreach ($currentMateriales as $material) {
                if (!in_array($material->id, $newMaterialesIds)) {
                    $deletedElements[] = $material;
                }
            }

            if (!empty($deletedElements)) {
                foreach ($deletedElements as $key => $deleted) {
                    Storage::delete($deleted->url);
                    $deleted->delete();
                }
            }
            /* the user has added new files an  could has deleted others */
        } elseif (!empty($request->url) && !empty($request->nombre) || !empty($request->url) && empty($request->nombre)) {

            $oldMateriales = $request->nombre;
            $newMateriales = $request->url;
            $currentMateriales = $anuncio->materiales()->get();
            $path = "";

            $newMaterialesIds = collect($oldMateriales)->pluck('id')->toArray();

            $deletedElements = [];
            foreach ($currentMateriales as $material) {
                if (!in_array($material->id, $newMaterialesIds)) {
                    $deletedElements[] = $material;
                }
            }

            if (!empty($deletedElements)) {
                foreach ($deletedElements as $key => $deleted) {
                    Storage::delete($deleted->url);
                    $deleted->delete();
                }
            }

            foreach ($newMateriales as $key => $materiale) {
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


    public function destroy($id)
    {
        $anuncio = Anuncio::find($id);

        $materiales = $anuncio->materiales;

        $anuncio->comentarios()->delete();

        $anuncio->delete();

        if (!empty($materiales)) {
            foreach ($materiales as $key => $materiale) {
                Storage::delete($materiale->url);
            }
        }
    }
}
