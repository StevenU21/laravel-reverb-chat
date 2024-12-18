<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
            'conversation_id' => 'required|exists:conversations,id',
            'content' => 'required|string|max:1000',
            'receiver_id' => 'required|exists:users,id',
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
            'conversation_id.required' => 'La conversación es requerida',
            'conversation_id.exists' => 'La conversación no existe',
            'content.required' => 'El contenido es requerido',
            'content.string' => 'El contenido debe ser un texto',
            'content.max' => 'El contenido no puede tener más de 1000 caracteres',
            'receiver_id.required' => 'El receptor es requerido',
            'receiver_id.exists' => 'El receptor no existe',
        ];
    }
}
