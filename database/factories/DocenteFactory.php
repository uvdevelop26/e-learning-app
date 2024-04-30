<?php

namespace Database\Factories;

use App\Models\Estado;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Docente>
 */
class DocenteFactory extends Factory
{

    public function definition()
    {
        $persona_id = Persona::all()->random()->id;
        $user_ids = User::where("role_id", 2)->pluck('id')->toArray();
        $estado_id = Estado::all()->random()->id;

        return [
            'profesion' => $this->faker->jobTitle(),
            'persona_id' => $persona_id,
            'user_id' => $this->faker->randomElement(array_unique($user_ids)),
            'estado_id' => $estado_id
        ];
    }
}
