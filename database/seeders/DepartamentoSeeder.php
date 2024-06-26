<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Exception;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DepartamentoSeeder extends Seeder
{

    public function run()
    {
        $url = storage_path('JSON/Departamentos_Paraguay_Codigos_DGEEC.json');

        try {
            $json = File::get($url);

            $json = mb_convert_encoding($json, 'UTF-8', 'UTF-8');

            $json = preg_replace('/[[:^print:]]/', '', $json);

            $departamentos = json_decode($json, true);

            // Verificar errores en json_decode
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar el JSON: " . json_last_error_msg());
            }

            // Utilizando print_r() para mostrar el contenido del array
            foreach ($departamentos as $departamento) {

                Departamento::create([
                    'nombre' => $departamento['descripcion_dpto']
                ]);
            }

            
        } catch (Exception $e) {
            echo "Excepción atrapada: " . $e->getMessage();
        }
    }
}
