<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Carrera>
 */
class CarreraFactory extends Factory
{
    
    public function definition()
    {
        $carreras = array("Ingeniería en Electricidad", "Ingeniería en Informática");

        return [
            'nombre' => $this->faker->randomElement($carreras),
            'codigo' => $this->faker->word(),
            'duracion' => $this->faker->word(),
            'descripcion' => $this->faker->sentence()
        ];
    }
}
