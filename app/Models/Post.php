<?php

namespace App\Models;

use App\Http\Traits\WithUuid;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';
    protected $fillable = ['uuid','user_id','file','description','suspend','file_type'];
    protected $attributes = [
      'post_type' => 'user'
    ];

    public function user(){
        return $this->belongsTo(User::class , 'user_id','uuid');
    }

    /**
     * Get the post's image.
     */
    public function likes()
    {
        return $this->hasMany('App\Models\Like','post_id', 'uuid')->where('post_type', '=', 'user');;
    }

    public function image()
    {
        return $this->morphOne('App\Models\Image', 'imageable','imageable_id');
    }
    public function video()
    {
        return $this->morphOne('App\Models\Video', 'videoable','videoable_id');
    }


    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable')->whereNull('parent_id')->where('post_type', '=', 'user');
//            ->whereNull('parent_id');
    }
}
