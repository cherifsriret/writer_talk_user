<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminPostTag extends Model
{
    use HasFactory;
    protected $table = 'admin_post_tags';
    protected $fillable = [
        'uuid','user_id','post_id','tag_id'
    ];
}
