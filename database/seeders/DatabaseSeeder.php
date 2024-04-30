<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Administradore;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Clase;
use App\Models\Comentario;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Persona;
use App\Models\Semestre;
use App\Models\Unidade;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $this->call(DepartamentoSeeder::class);
        $this->call(CiudadeSeeder::class);
        Persona::factory(50)->create();
        $this->call(RoleSeeder::class);
        $this->call(EstadoSeeder::class);
        // User::factory(20)->create();
        // Docente::factory(8)->create();
        //  Administradore::factory(4)->create();
        Carrera::factory(4)->create();
        // Alumno::factory(10)->create();
        $this->call(PermissionSeeder::class);
        Semestre::factory(8)->create();
        Materia::factory(10)->create();
        Clase::factory(3)->create();
    }
}
