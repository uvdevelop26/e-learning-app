<?php

namespace Database\Seeders;

use App\Models\Administradore;
use App\Models\Alumno;
use App\Models\Carrera;
use App\Models\Docente;
use App\Models\Persona;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                'email' => 'administrador@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role_id' => 3,
            ],
            [
                'email' => 'docente@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role_id' => 2,
            ],
            [
                'email' => 'alumno@gmail.com',
                'email_verified_at' => now(),
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'role_id' => 1,
            ],
        ];

        // transacciones para asegurar la integridad de los datos
        DB::transaction(function () use ($usuarios) {
            
            foreach ($usuarios as $index => $usuarioData) {
                
                $usuario = User::create($usuarioData);

                switch ($usuarioData['role_id']) {
                    case 3: // Administrador
                        Administradore::create([
                            'cargo' => 'secretario/a',
                            'persona_id' => $index + 1,
                            'user_id' => $usuario->id,
                            'estado_id' => 1,
                        ]);
                        break;

                    case 2: 
                        Docente::create([
                            'profesion' => 'Ingeniero en Sistemas',
                            'persona_id' => $index + 1, 
                            'user_id' => $usuario->id,
                            'estado_id' => 1,
                        ]);
                        break;

                    case 1: 
                        $carreraId = Carrera::pluck('id')->random();
                        Alumno::create([
                            'persona_id' => $index + 1,
                            'carrera_id' => $carreraId,
                            'user_id' => $usuario->id,
                            'estado_id' => 1,
                        ]);
                        break;
                }
            }
        });
    }
}
