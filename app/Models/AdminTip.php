<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminTip extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid',
        'user_id',
        'file',
        'file_type'
    ];
}
