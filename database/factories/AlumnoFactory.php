<?php

namespace Database\Factories;

use App\Models\Carrera;
use App\Models\Estado;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Alumno>
 */
class AlumnoFactory extends Factory
{

    public function definition()
    {
        static $usedPersonaIds = [];

        $personaIds = Persona::pluck('id')->diff($usedPersonaIds)->toArray();

        $userIds = User::where("role_id", 1)->pluck('id')->toArray();
        $carreraId = Carrera::pluck('id')->random();

        if (empty($personaIds)) {
            throw new \Exception("No hay más 'persona_id' únicos disponibles");
        }

        $personaId = $this->faker->randomElement($personaIds);
        $usedPersonaIds[] = $personaId;

        $estadoId = Estado::pluck('id')->random();

        return [
            'persona_id' => $personaId, 
            'carrera_id' => $carreraId,
            'user_id' => $this->faker->randomElement(array_unique($userIds)),
            'estado_id' => $estadoId
        ];
    }
}
