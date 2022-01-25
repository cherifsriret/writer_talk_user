<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuickText extends Model
{
    use HasFactory;
    protected $table = 'quicks_text';
    protected $fillable = ['id','uuid','text','updated_at','created_at'];
}
