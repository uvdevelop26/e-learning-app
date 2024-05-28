<?php

namespace Database\Seeders;

use App\Models\Administradore;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Persona;
use App\Models\User;
use GuzzleHttp\Promise\Create;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PermissionSeeder extends Seeder
{

    public function run()
    {



        $usuarios = [
            [
                'email' => 'guillermo@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'), // password
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
                'current_team_id' => null,
                'role_id' => 3,
            ],
            [
                'email' => 'juanalberto@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'), // password
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
                'current_team_id' => null,
                'role_id' => 2,
            ],
            [
                'email' => 'mariabaez@gmail.com',
                'email_verified_at' => now(),
                'password' => bcrypt('password'), // password
                'two_factor_secret' => null,
                'two_factor_recovery_codes' => null,
                'remember_token' => Str::random(10),
                'profile_photo_path' => null,
                'current_team_id' => null,
                'role_id' => 1,
            ],
        ];

        // Iterar sobre los datos y crear los usuarios
        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }

        /* $persona_id = Persona::all()->random()->id; */
        $carrera_id = Carrera::all()->random()->id;

        Administradore::create([
            'cargo' => 'secretario/a',
            'persona_id' => 1,
            'user_id' => 1,
            'estado_id' => 1
        ]);

        Docente::create([
            'profesion' => 'Ingeniero en Sistemas',
            'persona_id' => 2,
            'user_id' => 2,
            'estado_id' => 1
        ]);

        Alumno::create([
            'persona_id' => 3,
            'carrera_id' => $carrera_id,
            'user_id' => 3,
            'estado_id' => 1
        ]);
    }
}
