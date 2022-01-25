<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Highlight extends Model
{
    use HasFactory;
    protected $table = 'highlights';
    protected $fillable = [ 'uuid', 'user_id','file_image','title','views','file'];


    public function user(){
        return $this->belongsTo(User::class);
    }

    public function highlight_ratings()
    {
        return $this->hasMany(HighlightRating::class,'highlight_id','uuid');
    }
    public function highlight_views()
    {
        return $this->hasMany(HighlightView::class,'highlight_id','uuid');
    }

    public function highlight_genres()
    {
        return $this->hasMany(HighlightGenre::class,'highlight_id','uuid');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class,'commentable')->whereNull('parent_id')->where('post_type', '=', 'user');
//            ->whereNull('parent_id');
    }
}
