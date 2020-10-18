<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'account_type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function tutor()
    {
        return $this->hasOne(Tutor::class);
    }
    public function volunteer()
    {
        return $this->hasOne(Volunteer::class);
    }
    public function mentee()
    {
        return $this->hasOne(Mentee::class);
    }

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function Reviews()
    {
        return $this->hasMany('App\Review');
    }
    public function userNotifications()
    {
        return $this->hasMany(userNotification::class);
    }

    public function userMessages()
    {
        return $this->hasMany(userMessage::class);
    }

    public function courseCart()
    {
        return $this->hasOne(CourseCart::class);
    }

    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
    public function userQuizResults()
    {
        return $this->hasMany('App\UserQuizResult');
    }

    public function getJWTCustomClaims()
    {
        return [];
    }
    public function setPasswordAttribute($password)
    {
        if (!empty($password)) {
            $this->attributes['password'] = bcrypt($password);
        }
    }
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    public function userCourseProgresses()
    {
        return $this->hasMany(userCourseProgress::class);
    }
    public function wishlists()
    {
        return $this->hasMany(wishlist::class);
    }

}
