<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class AdminPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'user_id',
        'tip_type',
        'file',
        'file_type'
    ];


    public function video()
    {
        return $this->morphOne(Video::class, 'videoable');
    }

    public function likes()
    {
        return $this->hasMany(Like::class,'post_id', 'uuid')->where('post_type', '=', 'admin');
    }


    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable')->whereNull('parent_id')->where('post_type', '=', 'admin');
//            ->whereNull('parent_id');
    }
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'admin_post_tags','post_id','tag_id','uuid','uuid');
    }
}
