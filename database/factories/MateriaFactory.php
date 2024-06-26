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
        $semestres = Semestre::select('id', 'codigo')->get();

        $semestre = $semestres->random();

        return [
            'nombre' => $this->faker->word(),
            'codigo' => $semestre->codigo . $this->faker->numberBetween(1, 99),
            'horas_semanales' => $this->faker->numberBetween(1, 20),
            'plan_estudio' => $this->faker->sentence(),
            'descripcion' => $this->faker->sentence(),
            'semestre_id' => $semestre->id,
        ];
    }
}
