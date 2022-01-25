<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserPayment extends Model
{
    use HasFactory;
    protected $table = 'user_payments';
    protected $fillable = [
        'uuid','user_id', 'pay_key','days', 'payment', 'status',
        'end_date', 'promo_code'
    ];
}
