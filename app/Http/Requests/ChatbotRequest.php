<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatbotRequest extends FormRequest
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
            'message' => [
                'required',
                'string',
                'min:1', // Longitud mínima del mensaje
                'max:500', // Longitud máxima del mensaje
                'regex:/^[a-zA-Z0-9\s.,!?]+$/', // Solo permite letras, números y algunos caracteres de puntuación
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'message.required' => 'El mensaje es obligatorio.',
            'message.string' => 'El mensaje debe ser una cadena de texto.',
            'message.min' => 'El mensaje debe tener al menos 1 carácter.',
            'message.max' => 'El mensaje no puede tener más de 500 caracteres.',
            'message.regex' => 'El mensaje contiene caracteres no permitidos.',
        ];
    }
}
