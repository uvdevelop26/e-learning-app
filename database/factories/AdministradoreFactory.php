<?php

namespace Database\Factories;

use App\Models\Estado;
use App\Models\Persona;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Administradore>
 */
class AdministradoreFactory extends Factory
{


    public function definition()
    {
        static $usedPersonaIds = [];

        // obtener los IDs de Personas que aún no se han usado
        $personaIds = Persona::pluck('id')->diff($usedPersonaIds)->toArray();

        $userIds = User::where("role_id", 3)->pluck('id')->toArray();

        if (empty($personaIds)) {
            throw new \Exception("No hay más 'persona_id' únicos disponibles");
        }

        // ID de persona único
        $personaId = $this->faker->randomElement($personaIds);
        $usedPersonaIds[] = $personaId;

        $estadoId = Estado::pluck('id')->random();

        return [
            'cargo' => $this->faker->jobTitle(),
            'persona_id' => $personaId,
            'user_id' => $this->faker->randomElement(array_unique($userIds)),
            'estado_id' => $estadoId
        ];

       
    }
}
