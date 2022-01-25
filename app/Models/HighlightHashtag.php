<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightHashtag extends Model
{
    use HasFactory;

    protected $table = 'highlight_hashtags';
    protected $fillable = [
        'uuid','highlight_id','hashtag_id'
    ];
    public function highlight()
    {
        return $this->belongsTo(Highlight::class);
    }
}
