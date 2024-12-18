<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public static function getUserIdsWithConversations($userId)
    {
        return self::whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        })->with('users')->get()->pluck('users.*.id')->flatten()->unique()->toArray();
    }

    public function scopeForUser($query, $userId)
    {
        return $query->whereHas('users', function ($query) use ($userId) {
            $query->where('user_id', $userId);
        });
    }

    public static function getSender(Conversation $conversation)
    {
        return $conversation->users->firstWhere('id', auth()->id());
    }

    public static function getReceiver(Conversation $conversation)
    {
        return $conversation->users->firstWhere('id', '!=', auth()->id());
    }
}
