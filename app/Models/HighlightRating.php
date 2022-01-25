<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightRating extends Model
{
    use HasFactory;
    protected $table = 'highlight_ratings';
    protected $fillable = ['uuid','ip_address', 'user_id','highlight_id','rating','agent','comment','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function highlight()
    {
        return $this->belongsTo(Highlight::class);
    }
}
