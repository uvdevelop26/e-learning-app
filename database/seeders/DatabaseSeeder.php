<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administradore;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Persona;
use App\Models\Semestre;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(DepartamentoSeeder::class);
        $this->call(CiudadeSeeder::class);
        Persona::factory(20)->create();
        $this->call(RoleSeeder::class);
        $this->call(EstadoSeeder::class);
        User::factory(10)->create();
        Docente::factory(10)->create();
        Administradore::factory(4)->create();
        Carrera::factory(4)->create();
        Alumno::factory(20)->create();
        Semestre::factory(8)->create();
    }
}
