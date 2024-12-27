<?php

namespace App\Services;

use OpenAI\Laravel\Facades\OpenAI;

class ChatbotService
{
    protected $openAI;

    public function __construct(OpenAI $openAI)
    {
        $this->openAI = $openAI;
    }

    public function sendMessageToOpenAI(string $userMessage): array
    {
        $chatbotResponse = $this->openAI->chat()->create([
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

        return [
            'bot_message' => $chatbotResponse['choices'][0]['message']['content'],
            'input_tokens' => $chatbotResponse['usage']['prompt_tokens'],
            'output_tokens' => $chatbotResponse['usage']['completion_tokens']
        ];
    }
}
