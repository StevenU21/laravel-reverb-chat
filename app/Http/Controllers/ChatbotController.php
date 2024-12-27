<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatbotRequest;
use Illuminate\Http\JsonResponse;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    public function index()
    {
        return view('chatbot.index');
    }

    public function askGPT(ChatbotRequest $request): JsonResponse
    {
        // Obtener el mensaje del usuario
        $userMessage = $request->input('message');

        // Enviar el mensaje a OpenAI
        try {
            $chatbotResponse = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => 'You are a helpful assistant.'
                    ],
                    [
                        'role' => 'user',
                        'content' => $userMessage
                    ]
                ]
            ]);

            // Retornar una respuesta con el mensaje de éxito y la respuesta del chatbot
            return response()->json([
                'message' => 'Mensaje enviado correctamente, procesando...',
                'bot_message' => $chatbotResponse['choices'][0]['message']['content']
            ]);
        } catch (\Exception $e) {
            // Si ocurre un error, devolver un mensaje de error
            return response()->json([
                'message' => 'Error al procesar el mensaje.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
