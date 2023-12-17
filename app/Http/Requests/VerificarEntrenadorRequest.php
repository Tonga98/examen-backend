<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VerificarEntrenadorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'id_entrenador' => ['required','integer','exists:entrenadores,id']
        ];
    }

    public function messages(): array
    {
        return[
            'id_entrenador.required' => 'El campo id_entrenador es obligatorio.',
            'id_entrenador.integer' => 'El campo id_entrenador debe ser un número entero.',
            'id_entrenador.exists' => 'El entrenador seleccionado no existe en nuestra base de datos.'
        ];
    }
}
