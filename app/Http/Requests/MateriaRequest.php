<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MateriaRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'nombre' => 'required',
            'codigo' => 'required',
            'horas_semanales' => 'required',
            'plan_estudio' => 'nullable|file|mimes:pdf,doc,docx',
            'descripcion' => 'required',
            'semestre_id' => 'required',
            'carrera_id' => 'required'
        ];
    }
}
