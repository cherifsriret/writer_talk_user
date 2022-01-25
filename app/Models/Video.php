<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $table = 'videos';


    protected $fillable = ['uuid', 'url', 'videoable_id', 'videoable_type'];

    public function videoable()
    {
        return $this->morphTo(__FUNCTION__,'videoable_type', 'videoable_id');
    }
}
