<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserConnection extends Model
{
    use HasFactory;

    protected $table = 'user_connections';
    protected $fillable = [
        'uuid',
        'sender_id',
        'receiver_id'
    ];
}
