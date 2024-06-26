<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{

    public function run()
    {
        $estados = [
            ['estado' => 'activo'],
            ['estado' => 'inactivo']
        ];

        Estado::insert($estados);
    }
}
