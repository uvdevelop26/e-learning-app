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
            'titulo' => 'required|string|max:255',
            'instruccion' => 'required|string',
            'fecha_entrega' => 'required|date',
            'hora_entrega' => 'required',
            'puntos' => 'nullable|integer|min:0',
            'unidade_id' => 'nullable',
            'nombre' => 'nullable|array',
            'url' => 'nullable|array',
            'materiable_id' => 'nullable|numeric',
            'materiable_type' => 'required'
        ];
    }
}
