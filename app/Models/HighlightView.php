<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HighlightView extends Model
{
    use HasFactory;

    protected $table = 'highlight_views';
    protected $fillable = ['uuid', 'ip_address',
        'agent','user_id','highlight_id','view','status'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function highlight()
    {
        return $this->belongsTo(Highlight::class);
    }
}
