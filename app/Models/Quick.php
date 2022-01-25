<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quick extends Model
{
    use HasFactory;
    protected $table = 'quicks';
    protected $fillable = ['uuid','user_id','file','updated_at','created_at'];
        public function users()
    {
        return $this->belongsTo(User::class);
    }
}
