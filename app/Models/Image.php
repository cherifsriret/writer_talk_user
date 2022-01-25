<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;
    protected $table = 'images';
    protected $fillable = ['uuid','url', 'imageable_id', 'imageable_type'];
    public function imageable()
    {
        return $this->morphTo(__FUNCTION__,'imageable_type', 'imageable_id' );
    }


}
