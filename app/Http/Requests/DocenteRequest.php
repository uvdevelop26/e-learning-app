<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DocenteRequest extends FormRequest
{
   
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'nombre' => 'required',
            'apellido' => 'required',
            'ci_numero' => 'required',
            'sexo' => 'required',
            'telefono' => 'required',
            'direccion' => 'required',
            'ciudade_id' => 'required',
            'profesion' => 'required',
            'estado_id' => 'required',
            'email' => 'required',
            'password' => 'required|confirmed|min:7',
            'role_id' => 'required'
        ];
    }
}
