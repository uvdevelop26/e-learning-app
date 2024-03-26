<?php

namespace Database\Factories;

use App\Models\Docente;
use App\Models\Estado;
use App\Models\Materia;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Clase>
 */
class ClaseFactory extends Factory
{

    public function definition()
    {
        $materia_id = Materia::all()->random()->id;
        $docente_id = Docente::all()->random()->id;
        $estado_id = Estado::all()->random()->id;

        return [
            'codigo' => $this->faker->word(),
            'materia_id' => $materia_id,
            'docente_id' => $docente_id,
            'estado_id' => $estado_id
        ];
    }
}
