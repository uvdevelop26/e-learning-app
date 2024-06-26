<?php

namespace Database\Seeders;

use App\Models\Carrera;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarreraSeeder extends Seeder
{

    public function run()
    {
        $carreras = [
            [
                'nombre' => 'Ingeniería en Informática',
                'codigo' => 'IEI',
                'duracion' => '6 años',
                'descripcion' => '--'
            ],
            [
                'nombre' => 'Ingeniería en Electricidad',
                'codigo' => 'IEE',
                'duracion' => '5 años',
                'descripcion' => '--'
            ],
        ];

        Carrera::insert($carreras);
    }
}
