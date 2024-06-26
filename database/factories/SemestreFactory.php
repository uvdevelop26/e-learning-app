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
        $nombres = ["I", "II", "III", "IV", "V", "VI", "VII", "VIII", "IX", "X", "XI", "XII"];

        $carreras = Carrera::select('id', 'codigo')->get();

        $carrera = $carreras->random();

        $nombreSemestre = $this->faker->randomElement($nombres);

        return [
            'nombre' => $nombreSemestre,
            'codigo' => $carrera->codigo . '-' . $nombreSemestre,
            'descripcion' => $this->faker->sentence(5),
            'carrera_id' => $carrera->id 
        ];
    }
}
