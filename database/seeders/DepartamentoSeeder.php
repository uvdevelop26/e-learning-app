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

            // Asegurarte que se maneje como UTF-8
            if (!mb_check_encoding($json, 'UTF-8')) {
                $json = utf8_encode($json);
            }

            $departamentos = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new Exception("Error al decodificar el JSON: " . json_last_error_msg());
            }

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
