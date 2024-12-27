<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class ChatbotService
{
    public function sendMessageToOpenAI(string $userMessage): array
    {
        $chatbotResponse = OpenAI::chat()->create([
            'model' => 'gpt-4o-mini',
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

        return [
            'bot_message' => $chatbotResponse['choices'][0]['message']['content'],
            'input_tokens' => $chatbotResponse['usage']['prompt_tokens'],
            'output_tokens' => $chatbotResponse['usage']['completion_tokens']
        ];
    }
}
