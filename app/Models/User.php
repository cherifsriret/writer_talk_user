<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, HasApiTokens, Notifiable;
//         protected $guard = 'api';
    protected $table = 'users';
        /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid',
        'name',
        'email',
        'views',
        'contact_no',
        'status',
        'bio',
        'image',
        'verify_user',
        'country_code',
        'favorite_genres',
        'invitation_key',
        'password',
        'promo_code','promo_used','referral_used',
        'secret_key','api_token','device_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'secret_key'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function posts(){
        return $this->hasMany(Post::class,'user_id','uuid');
    }
    public function stories(){
        return $this->hasMany(Story::class,'user_id','uuid');
    }

    public function highlights(){
        return $this->hasMany(Highlight::class,'user_id','uuid');
    }
    public function user_profile_views()
    {
        return $this->hasMany(UserProfileView::class,'user_id','uuid');
    }
    public function penpals(){
        return $this->belongsToMany(User::class,'penpals','sender_id', 'receiver_id','uuid','uuid');
    }

    public function likes()
    {
        return $this->hasMany(Like::class,'user_id', 'uuid');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class,'user_id', 'uuid');
    }

    /**
     * Get the user's image.
     */
    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }
//    public static function boot()
//    {
//        parent::boot();
//        self::creating(function ($model) {
//            $model->uuid = Str::uuid();
//        });
//    }

    public function groups(){
        return $this->belongsToMany(Group::class,'group_users','user_id','group_id');
    }
    public function quick()
    {
        return $this->hasMany(Quick::class);
    }
}
