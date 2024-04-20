<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReservaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'reservable_id' => ['required', 'integer'],
            'reservable_type' => ['required', 'string'],
            'asignado_a' => ['required', 'exists:users,id'],
            'fecha' => ['required', 'date'],
            'horas' => ['required'],
            'comentario' => ['nullable', 'string'],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */

    public function messages(): array
    {
        return [
            'reservable_id.required' => 'Debes seleccionar un espacio o recurso',
            'reservable_id.integer' => 'El espacio o recurso que se ha seleccionado no es válido',
            'reservable_type.required' => 'El tipo de espacio es obligatorio',
            'reservable_type.string' => 'El tipo de espacio seleccionado no es válido',
            'asignado_a.required' => 'El usuario es obligatorio',
            'asignado_a.exists' => 'El usuario no existe',
            'fecha.required' => 'La fecha es obligatoria',
            'fecha.date' => 'La fecha debe ser una fecha válida',
            'horas.required' => 'Las horas son obligatorias',
            'comentario.string' => 'El comentario debe ser un texto',
        ];
    }
}
