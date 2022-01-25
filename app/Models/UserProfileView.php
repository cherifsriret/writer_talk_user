<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserProfileView extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'ip_address',
        'user_id',
        'agent',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
