<?php

namespace Database\Factories;

use App\Models\Clase;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Unidade>
 */
class UnidadeFactory extends Factory
{
    
    public function definition()
    {

        $clase_id = Clase::all()->random()->id;

        return [
            'numero' => $this->faker->numberBetween(1, 100),
            'tema' => $this->faker->word(),
            'objetivos' => $this->faker->sentence(),
            'clase_id' => $clase_id
        ];
    }
}
