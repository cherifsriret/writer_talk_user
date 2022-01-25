<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserMessages extends Model
{
    use HasFactory;
    protected $table = 'user_messages';
    protected $fillable = [
        'uuid', 'connection_id', 'sender_id', 'receiver_id', 'message',
    ];
}
