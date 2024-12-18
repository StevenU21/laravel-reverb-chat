<?php
namespace App\Events;

use App\Models\Conversation;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageReadEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversationId;
    public $userId;

    // public function __construct($conversationId, $userId)
    // {
    //     $this->conversationId = $conversationId;
    //     $this->userId = $userId;
    // }

    public function __construct($conversationId, $userId, $messages)
    {
        $this->conversationId = $conversationId;
        $this->userId = $userId;
        $this->messages = $messages;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat-channel.' . $this->conversationId);
    }

    public function broadcastWith()
    {
        return [
            'user_id' => $this->userId,
            'conversation_id' => $this->conversationId,
        ];
    }

}
