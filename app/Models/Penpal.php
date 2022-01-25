<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penpal extends Model
{
    use HasFactory;
    protected $table = 'penpals';
    protected $fillable = ['uuid',  'sender_id', 'receiver_id', 'status'];

//    public function users(){
//        return $this->belongsToMany(User::class,'penpals');
//    }
}
