<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class DocenteRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $docente = $this->route('docente');
        $personaId = $docente ? $docente->persona_id : null;
        $userId = $docente ? $docente->user_id : null;

        return [
            'nombre' => 'required|string|max:200',
            'apellido' => 'required|string|max:200',
            'ci_numero' => [
                'required',
                'string',
                'max:100',
                Rule::unique('personas', 'ci_numero')->ignore($personaId),
            ],
            'sexo' => 'required|string|max:50',
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'ciudade_id' => 'required',
            'departamento_id' => 'required',
            'profesion' => 'required|string|max:255',
            'estado_id' => 'required',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'password' => 'required|string|confirmed|min:7',
            'role_id' => 'required'
        ];
    }
}
