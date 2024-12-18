<?php

namespace App\Policies;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ConversationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Conversation $conversation)
    {
        return $conversation->users->contains($user->id);
    }
}
