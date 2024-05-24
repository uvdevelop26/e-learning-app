<?php

namespace App\Http\Controllers;

use App\Models\MaterialeTarea;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MaterialeTareaController extends Controller
{
    public function download($id)
    {
        $materiale = MaterialeTarea::find($id);

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
