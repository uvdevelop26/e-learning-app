<?php

namespace Database\Seeders;

use App\Models\Estado;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstadoSeeder extends Seeder
{
    
    public function run()
    {
        $estados = array("activo", "inactivo");

        foreach ($estados as $estado) {
            Estado::create([
                'estado' => $estado
            ]);
        }
    }
}
