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
            'nombre' => 'required|string|max:200',
            'apellido' => 'required|string|max:200',
            'ci_numero' => 'required|string|max:100|unique:personas,ci_numero',
            'sexo' => 'required|string|max:50',
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:255',
            'ciudade_id' => 'required',
            'departamento_id' => 'required',
            'profesion' => 'required|string|max:255',
            'estado_id' => 'required',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|string|confirmed|min:7',
            'role_id' => 'required'
        ];
    }
}
