<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewEquipoRequest extends FormRequest
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
            'nombre' => ['required','string','max:30'],
            'id_entrenador' => ['required','integer', 'exists:entrenadores,id'],
            'pokemones' => ['required', 'max:3', 'min:1'],
            'id_primero' => ['nullable','integer'],
            'id_segundo' => ['nullable','integer'],
        ];
    }
}
