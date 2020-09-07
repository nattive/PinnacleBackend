<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseDiscount extends Model
{
    protected $fillable = [
        'name',
        'banner',
        'type',
        'due',
        'code',
        'active',
        'tutor_id',
        'course_id',
        'user_id',
          'discount'
    ];
    public function Tutor()
    {
        return $this->hasOne(Tutor::class);
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
