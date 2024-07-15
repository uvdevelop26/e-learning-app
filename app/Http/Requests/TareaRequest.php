<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TareaRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

    
    public function rules()
    {
        return [
            'titulo' => 'required',
            'instruccion' => 'required',
            'fecha_entrega' => 'required',
            'hora_entrega' => 'required',
            'puntos' => 'nullable|numeric',
            'unidade_id' => 'nullable',
            'nombre' => 'nullable|array',
            'url' => 'nullable|array',
            'materiable_id' => 'nullable|numeric',
            'materiable_type' => 'required'
        ];
    }
}
