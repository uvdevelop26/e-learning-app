<?php

namespace Database\Seeders;

use App\Models\Ciudade;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CiudadeSeeder extends Seeder
{

    public function run()
    {
        $url = storage_path('JSON/Distritos_Paraguay_Codigos_DGEEC.json');

        try {
            // Obtener el contenido del archivo
            $json = File::get($url);

            // Asegurarte de que el contenido esté en UTF-8
            if (!mb_check_encoding($json, 'UTF-8')) {
                $json = utf8_encode($json);
            }

            // Decodificar el JSON en un array asociativo
            $distritos = json_decode($json, true);

            // Verificar errores en json_decode
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar el JSON: " . json_last_error_msg());
            }

            // Insertar los datos en la base de datos
            foreach ($distritos as $distrito) {
                Ciudade::create([
                    'nombre' => $distrito['Descripción de Distrito'],
                    'departamento_id' => $distrito['Código de Departamento']
                ]);
            }
        } catch (Exception $e) {
            echo "Excepción atrapada: " . $e->getMessage();
        }
    }
}
