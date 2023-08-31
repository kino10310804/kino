<?php

namespace App;
// use App\Notifications\PasswordResetUserNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
// use Illuminate\Support\Facades\Hash;
class User extends Authenticatable
{
     use Notifiable;
     protected $rememberTokenName = false; 

    protected $fillable = [
    'name','email','password','profile','image','role',
    ];

    public function comment()
    {
        return $this->belongsTo('App\Comment');
    }
    public function post()
    {
        return $this->belongsTo('App\Post');
    }
    public function likes()
    {
        return $this->hasMany('App\Like');
    }
    public function violations()
    {
        return $this->hasMany('App\Violation');
    }
    // protected $hidden = [
    //     'password', 'remember_token',
    // ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // public function sendPasswordResetNotification($token)
    // {
    //     $this->notify(new PasswordResetUserNotification($token));    
    // }   
}
