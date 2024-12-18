<?php

namespace App\Livewire;

use App\Models\Conversation;
use Livewire\Component;

class ViewConversation extends Component
{
    public $conversation;

    public function mount(Conversation $conversation)
    {
        $this->conversation = $conversation;
    }

    public function render()
    {
        return view('livewire.view-conversation');
    }
}
