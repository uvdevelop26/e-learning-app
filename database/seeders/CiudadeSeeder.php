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
            $json = File::get($url);

            $json = mb_convert_encoding($json, 'UTF-8', 'UTF-8');

            $json = preg_replace('/[[:^print:]]/', '', $json);

            $distritos = json_decode($json, true);

            // Verificar errores en json_decode
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar el JSON: " . json_last_error_msg());
            }


            foreach ($distritos as $distrito) {

                Ciudade::create([
                    'nombre' => $distrito['Descripcin de Distrito'],
                    'departamento_id' => $distrito['Cdigo de Departamento']
                ]);
            }
        } catch (Exception $e) {
            echo "Excepción atrapada: " . $e->getMessage();
        }
    }
}
