<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $guard = 'admin';

    protected $fillable = [
        'name', 'email', 'password', 'image'
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];
    public function tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
    public function blogPosts()
    {
        $this->hasMany(BlogPost::class);
    }
      public function freeResources()
    {
        $this->hasMany(FreeResources::class);
    }
}
