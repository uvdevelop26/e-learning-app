<?php

namespace Database\Factories;

use App\Models\Carrera;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Semestre>
 */
class SemestreFactory extends Factory
{
    
    public function definition()
    {
        $nombres = array("I", "II", "III", "IV", "V","VI", "VII", "VIII", "IX", "X", "XI", "XII");
        $carrera_id = Carrera::all()->random()->id;

        return [
            'nombre' => $this->faker->randomElement($nombres),
            'codigo' => $this->faker->word(),
            'descripcion' => $this->faker->sentence(5),
            'carrera_id' => $carrera_id
        ];
    }
}
