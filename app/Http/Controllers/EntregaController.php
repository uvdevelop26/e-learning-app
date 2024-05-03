<?php

namespace App\Http\Controllers;

use App\Http\Requests\EntregaRequest;
use App\Models\Entrega;
use App\Models\MaterialeTarea;
use Illuminate\Support\Facades\Storage;
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

    public function update(EntregaRequest $request, $id)
    {
        $entrega = Entrega::findOrFail($id);

        $entrega->update([
            'completado' => $request->completado,
            'puntaje' => $request->puntaje,
            'tarea_id' => $request->tarea_id,
            'user_id' => $request->user_id
        ]);

        /* the user has deleted all the all files and has'nt added new ones */
        if (empty($request->url) && empty($request->nombre)) {
            $materiales = $entrega->materiales()->get();

            foreach ($materiales as $key => $materiale) {
                Storage::delete($materiale->url);
            }

            $entrega->materiales()->delete();
        } elseif (empty($request->url) && !empty($request->nombre)) {

            /* obtener y eliminar  los materiales eliminados */

            $oldMateriales = $request->nombre;
            $currentMateriales = $entrega->materiales()->get();

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
            $currentMateriales = $entrega->materiales()->get();
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
                $path = $materiale->storeAs('public/tareas', $filename);

                MaterialeTarea::create([
                    'nombre' => $materiale->getClientOriginalName(),
                    'url' => $path,
                    'materiable_id' => $request->materiable_id,
                    'materiable_type' => $request->materiable_type
                ]);
            }
        }
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
