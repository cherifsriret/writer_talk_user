<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightGenre extends Model
{
    use HasFactory;
    protected $fillable = ['uuid', 'highlight_id','genre_id'];
}
