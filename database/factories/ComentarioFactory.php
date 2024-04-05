<?php

namespace Database\Factories;

use App\Models\Anuncio;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;


class ComentarioFactory extends Factory
{
    
    public function definition()
    {
        $anuncio_id = Anuncio::all()->random()->id;
        $user_id = User::all()->random()->id;

        return [
            'contenido' => $this->faker->sentence(),
            'anuncio_id' => $anuncio_id,
            'user_id' => $user_id
        ];
    }
}
