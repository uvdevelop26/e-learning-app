<?php

namespace App\Http\Controllers;

use App\Http\Requests\TareaRequest;
use App\Models\MaterialeTarea;
use App\Models\Tarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

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
        $materiales = $request->url;

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

        if (!empty($materiales)) {
            $path = "";

            foreach ($materiales as $key => $materiale) {
                $extension = $materiale->getClientOriginalExtension();
                $filename = time() . $key . '.' . $extension;
                $path = $materiale->storeAs('public/tareas', $filename);

                MaterialeTarea::create([
                    'nombre' => $materiale->getClientOriginalName(),
                    'url' => $path,
                    'materiable_id' => $tarea->id,
                    'materiable_type' => $request->materiable_type
                ]);
            }
        }
    }


    public function show($clase, $unidad, $tarea)
    {

        $tareaYmateriales = Tarea::with([
            'comentarios.user.alumnos.persona',
            'materiales', 'entregas.user',
            'entregas.materiales'
        ])
            ->findOrFail($tarea);


        return Inertia::render('Tareas/Show', [
            'tareaYmateriales' => $tareaYmateriales,
            'clase_id' => $clase,
            'unidade_id' => $unidad
        ]);
    }

    public function edit($id)
    {
        //
    }

    public function update(TareaRequest $request, $id)
    {
        $tarea = Tarea::findOrFail($id);

        $instruccionArray = $request->instruccion;

        $textoInstruccion = '';

        if (is_array($instruccionArray)) {
            foreach ($instruccionArray['ops'] as $op) {
                if (isset($op['insert'])) {
                    $textoInstruccion .= $op['insert'];
                }
            }
        } else {

            $textoInstruccion = $instruccionArray;
        }

        $tarea->update([
            'titulo' => $request->titulo,
            'instruccion' => $textoInstruccion,
            'fecha_entrega' => $request->fecha_entrega,
            'hora_entrega' => $request->hora_entrega,
            'puntos' => $request->puntos,
            'unidade_id' => $request->unidade_id
        ]);

        /* the user has deleted all the all files and has'nt added new ones */
        if (empty($request->url) && empty($request->nombre)) {
            $materiales = $tarea->materiales()->get();

            foreach ($materiales as $key => $materiale) {
                Storage::delete($materiale->url);
            }

            $tarea->materiales()->delete();
        } elseif (empty($request->url) && !empty($request->nombre)) {

            /* obtener y eliminar  los materiales eliminados */

            $oldMateriales = $request->nombre;
            $currentMateriales = $tarea->materiales()->get();

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
            $currentMateriales = $tarea->materiales()->get();
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
        $tarea = Tarea::findOrFail($id);

        $tarea->delete();
    }
}
