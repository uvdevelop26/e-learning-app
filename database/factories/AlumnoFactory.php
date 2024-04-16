<?php

namespace Database\Factories;

use App\Models\Carrera;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumno>
 */
class AlumnoFactory extends Factory
{
    
    public function definition()
    {
        $persona_id = Persona::all()->random()->id;
        $carrera_id = Carrera::all()->random()->id;
        $user_id = User::where("role_id", 1)->get();
        $estado_id = Estado::all()->random()->id;

        return [
            'persona_id' => $persona_id,
            'carrera_id' => $carrera_id,
            'user_id' => $this->faker->randomElement($user_id)->id,
            'estado_id' => $estado_id
        ];
    }
}
