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
        $materias = Materia::select('id', 'codigo')->get();
        $docenteId = Docente::pluck('id')->random();
        $estadoId = Estado::pluck('id')->random();
        $materia = $materias->random();

        return [
            'codigo' => $materia->codigo . $this->faker->numberBetween(1, 99),
            'materia_id' => $materia->id,
            'docente_id' => $docenteId,
            'estado_id' => $estadoId
        ];
      
    }
}
