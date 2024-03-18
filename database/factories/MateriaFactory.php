<?php

namespace Database\Factories;

use App\Models\Semestre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Materia>
 */
class MateriaFactory extends Factory
{
    
    public function definition()
    {
        $semestre_id = Semestre::all()->random()->id;

        return [
            'nombre' => $this->faker->word(),
            'codigo' => $this->faker->word(),
            'horas_semanales' => $this->faker->numberBetween(4, 100),
            'plan_estudio' => $this->faker->sentence(),
            'descripcion' => $this->faker->sentence(),
            'semestre_id' => $semestre_id,
        ];
    }
}
