<?php

namespace App\Http\Requests;

use App\Models\Usuario;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'nombre_comercial' => ['required', 'string', 'max:150'],
            'ciudad' => ['required', 'string', 'max:100'],
            'correo' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:150',
                Rule::unique(Usuario::class, 'correo')->ignore($this->user()->id_usuario, 'id_usuario'),
            ],
        ];
    }
}
