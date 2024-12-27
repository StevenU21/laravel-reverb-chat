<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index():View
    {
        $userId = auth()->id();
        $existingConversationUserIds = Conversation::getUserIdsWithConversations($userId);

        $existingConversationUserIds = array_diff($existingConversationUserIds, [$userId]);

        $users = User::where('id', '!=', $userId)
            ->whereNotIn('id', $existingConversationUserIds)
            ->get();

        return view('dashboard', compact('users'));
    }
}
