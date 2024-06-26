<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    
    public function run()
    {
        $roles = [
            ['rol' => 'alumno'],
            ['rol' => 'docente'],
            ['rol' => 'administrador']
        ];

        Role::insert($roles);
    }
}
