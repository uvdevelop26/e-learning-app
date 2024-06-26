<?php

namespace Database\Factories;

use App\Models\Ciudade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Persona>
 */
class PersonaFactory extends Factory
{
   
    public function definition()
    {
        $sexos = array("femenino", "masculino");

        $ciudade_id = Ciudade::pluck('id')->random();

        return [
            'nombre' => $this->faker->name(),
            'apellido' => $this->faker->lastName(),
            'ci_numero' => $this->faker->unique()->numberBetween(1000000, 5000000),
            'sexo' => $this->faker->randomElement($sexos),
            'telefono' => $this->faker->phoneNumber(),
            'direccion' => $this->faker->sentence(5),
            'ciudade_id' => $ciudade_id
        ];
    }
}
