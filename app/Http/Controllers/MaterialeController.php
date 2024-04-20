<?php

namespace App\Http\Controllers;

use App\Models\Materiale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MaterialeController extends Controller
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
        //
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
        //
    }

    public function download($id)
    {
        $materiale = Materiale::find($id);

        $path = storage_path("app/{$materiale->url}");

        if (empty($materiale->url) || !File::exists($path)) {
            abort(404);
        }

        // Obtener el tipo MIME del archivo
        $mime = mime_content_type($path);

        // Leer el contenido del archivo
        $contenido = file_get_contents($path);

        return response()->make($contenido, 200, [
            'Content-Type' => $mime,
            'Content-Disposition' => 'inline; filename="' . $materiale->nombre,
        ]);

        

    }
}
