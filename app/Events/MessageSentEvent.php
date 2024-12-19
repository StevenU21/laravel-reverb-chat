<?php

namespace App\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MessageSentEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $content;

    public function __construct($content)
    {
        $this->content = $content;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat-channel.' . $this->content->conversation_id);
    }

    public function broadcastWith()
    {
        return [
            'content' => $this->content->content,
            'sender_name' => $this->content->sender_name,
            'sender_id' => $this->content->sender_id,
            'created_at' => $this->content->created_at,
        ];
    }
}
