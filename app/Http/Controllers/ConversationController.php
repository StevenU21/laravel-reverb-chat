<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConversationRequest;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ConversationController extends Controller
{
    public function index():View
    {
        $userId = auth()->id();
        $conversations = Conversation::forUser($userId)
            ->with([
                'users',
                'messages' => function ($query) {
                    $query->latest();
                }
            ])
            ->get()
            ->map(function ($conversation) {
                $conversation->latest_message = $conversation->messages->first();
                return $conversation;
            });

        return view('conversations.index', compact('conversations'));
    }
    public function store(ConversationRequest $request):RedirectResponse
    {
        $sender = auth()->user()->id;
        $receiver = $request->input('user_id');

        $conversation_name = auth()->user()->name . ' & ' . User::findOrFail($receiver)->name;

        $conversation = Conversation::create([
            'name' => $conversation_name,
            'slug' => Str::slug($conversation_name, '-')
        ]);

        $conversation->users()->attach([$sender, $receiver]);

        return redirect()->route('conversations.show', ['conversation' => $conversation->slug]);
    }
    public function show(Conversation $conversation)
    {
        if (Gate::denies('view', $conversation)) {
            return back()->with('error', 'You are not allowed to view this conversation.');
        }

        $userId = auth()->id();
        $conversation->load('users', 'messages.user');
        $conversations = Conversation::forUser($userId)->with('users')->get();

        // Paginate messages
        $messages = $conversation->messages()->with('user')->orderBy('created_at', 'asc')->get();

        $sender = Conversation::getSender($conversation);
        $receiver = Conversation::getReceiver($conversation);

        return view('conversations.show', compact('conversation', 'sender', 'receiver', 'messages', 'conversations'));
    }
}
