<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }


    public function rules()
    {
        $profile = $this->route('profile');
        $userId = $profile ? $profile->user_id : null;

        return [
            'telefono' => 'required|string|max:50',
            'direccion' => 'required|string|max:200',
            'nombre' => 'required|string|max:200',
            'apellido' => 'required|string|max:200',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($userId),
            ],
            'photo' => 'nullable'
        ];
    }
}
