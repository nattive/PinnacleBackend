<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tutor extends Model
{
    protected $fillable = [
        'isCotF_tutor',
        'isPO_tutor',
        'isActive',
        'rating',
        'name',
        'image',
        'about',
        'files',
        'isAdmin',
        'admin_id',
        'user_id',
        'facebook',
        'twitter',
        'linkedIn',
        'youTube',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function admin()
    {
        return $this->hasOne('App\Admin');
    }

    public function courses()
    {
        return $this->hasMany('App\Course');
    }
    public function courseActivities()
    {
        return $this->hasMany(CourseActivity::class);
    }
    public function CourseDiscounts()
    {
        return $this->hasMany(CourseDiscount::class);
    }
}

