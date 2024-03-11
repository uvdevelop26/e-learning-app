<?php

namespace Database\Seeders;

use App\Models\Ciudade;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CiudadeSeeder extends Seeder
{
    
    public function run()
    {

        $ciudades = array(
            array('id' =>136, 'dpto_id' => 5, 'distrito' => 'Borja'),
            array('id' =>137, 'dpto_id' => 5, 'distrito' => 'Colonia Independencia'),
            array('id' =>138, 'dpto_id' => 5, 'distrito' => 'Coronel Martínez'),
            array('id' =>139, 'dpto_id' => 5, 'distrito' => 'Dr. Bottrell'),
            array('id' =>140, 'dpto_id' => 5, 'distrito' => 'Fassardi'),
            array('id' =>141, 'dpto_id' => 5, 'distrito' => 'Félix Pérez Cardozo'),
            array('id' =>142, 'dpto_id' => 5, 'distrito' => 'Garay'),
            array('id' =>143, 'dpto_id' => 5, 'distrito' => 'Itapé'),
            array('id' =>144, 'dpto_id' => 5, 'distrito' => 'Iturbe'),
            array('id' =>145, 'dpto_id' => 5, 'distrito' => 'Mbocayaty'),
            array('id' =>146, 'dpto_id' => 5, 'distrito' => 'Natalicio Talavera'),
            array('id' =>147, 'dpto_id' => 5, 'distrito' => 'Ñumí'),
            array('id' =>148, 'dpto_id' => 5, 'distrito' => 'Paso Yobái'),
            array('id' =>149, 'dpto_id' => 5, 'distrito' => 'San Salvador'),
            array('id' =>150, 'dpto_id' => 5, 'distrito' => 'Tebicuary'),
            array('id' =>151, 'dpto_id' => 5, 'distrito' => 'Troche'),
            array('id' =>152, 'dpto_id' => 5, 'distrito' => 'Villarrica'),
            array('id' =>153, 'dpto_id' => 5, 'distrito' => 'Yataity')
        );

        foreach ($ciudades as $ciudad) {

            Ciudade::create([

                'id' => $ciudad['id'],
                'nombre' => $ciudad['distrito'],
                'departamento_id' => $ciudad['dpto_id']
            ]);

        }
        
        
    }
}
