<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChatbotRequest;
use App\Services\ChatbotService;
use Illuminate\Http\JsonResponse;
use OpenAI\Laravel\Facades\OpenAI;

class ChatbotController extends Controller
{
    protected $chatbotService;

    public function __construct(ChatbotService $chatbotService)
    {
        $this->chatbotService = $chatbotService;
    }

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
            $response = $this->chatbotService->sendMessageToOpenAI($userMessage);

            return response()->json([
                'message' => 'Mensaje enviado correctamente, procesando...',
                'bot_message' => $response['bot_message'],
                'input_tokens' => $response['input_tokens'],
                'output_tokens' => $response['output_tokens']
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
