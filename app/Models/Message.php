<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Crypt;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'content',
        'conversation_id',
        'sender_id',
        'receiver_id',
        'is_read',
    ];

    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function getSenderNameAttribute()
    {
        return $this->user->name;
    }

    // Método para marcar el mensaje como leído
    public function markAsRead()
    {
        $this->is_read = true;
        $this->save();
    }
}
