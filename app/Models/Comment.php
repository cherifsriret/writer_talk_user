<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'user_id',
        'post_id',
        'parent_id',
        'post_type',
        'comment',
        'comment_type',
        'commentable_id',
        'commentable_type'
    ];

    public function post()
    {
        return $this->belongsTo('App\Models\Post');
    }

    public function admin_post()
    {
        return $this->belongsTo('App\Models\AdminPost');
    }
    public function highlight()
    {
        return $this->belongsTo('App\Models\Highlight');
    }
    public function user(){
        return $this->belongsTo(User::class);

    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent_id','uuid');
    }
    public function commentable()
    {
        return $this->morphTo('commentable');
    }
//
//    /**
//     * Get all of the comment's likes.
//     */
////    public function likes()
////    {
////        return $this->morphMany('App\Like', 'likeable');
////    }
}

