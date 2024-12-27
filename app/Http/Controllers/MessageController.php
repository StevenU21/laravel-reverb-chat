<?php

namespace App\Http\Controllers;

use App\Events\MessageReadEvent;
use App\Events\MessageSentEvent;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use Illuminate\Http\JsonResponse;
class MessageController extends Controller
{
    public function store(MessageRequest $request): JsonResponse
    {
        $message = Message::create($request->validated() + [
            'sender_id' => auth()->id(),
        ]);
        MessageSentEvent::dispatch($message);

        return response()->json([
            'message' => 'Message sent successfully',
            'data' => $message
        ]);
    }
    public function markAsRead($conversationId): JsonResponse
    {
        $userId = auth()->id();

        Message::where('conversation_id', $conversationId)
            ->where('receiver_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        // Despacha el evento para notificar al frontend
        MessageReadEvent::dispatch($conversationId, $userId);

        return response()->json(['message' => 'Messages marked as read']);
    }
}
