<?php

namespace Database\Seeders;

use App\Models\Departamento;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class DepartamentoSeeder extends Seeder
{

    public function run()
    {

        $departamentos = array(
            array('id' => 1, 'departamento' => 'Central'),
            array('id' => 2, 'departamento' => 'Concepción'),
            array('id' => 3, 'departamento' => 'San Pedro'),
            array('id' => 4, 'departamento' => 'Coordillera'),
            array('id' => 5, 'departamento' => 'Guairá'),
            array('id' => 6, 'departamento' => 'Caaguazú'),
            array('id' => 7, 'departamento' => 'Caazapá'),
            array('id' => 8, 'departamento' => 'Itapúa'),
            array('id' => 9, 'departamento' => 'Misiones'),
            array('id' => 10, 'departamento' => 'Paraguarí'),
            array('id' => 11, 'departamento' => 'Alto Paraná'),
            array('id' => 12, 'departamento' => 'Ñeembucú'),
            array('id' => 13, 'departamento' => 'Amambay'),
            array('id' => 14, 'departamento' => 'Canindeyú'),
            array('id' => 15, 'departamento' => 'Presidente Hayes'),
            array('id' => 16, 'departamento' => 'Boquerón'),
            array('id' => 17, 'departamento' => 'Alto Paraguay')
        );

        foreach ($departamentos as $departamento) {

            Departamento::create([
                'id' => $departamento['id'],
                'nombre' => $departamento['departamento']
            ]);
        }
    }
}
