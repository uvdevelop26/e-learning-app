<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    
    public function run()
    {
        $roles = array("alumno", "docente", "administrador");

        foreach ($roles as $role) {

            Role::create([
                'rol' => $role
            ]);
        }
    }
}
