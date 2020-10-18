<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCartItem extends Model
{
    protected $fillable = [
        'course_cart_id',
        'course_id',
        'cost',
    ];
    public function CourseCart()
    {
        return $this->belongsTo(CourseCart::class);
    }
    public function course()
    {
        return $this->belongsToMany('App\Course', 'course_id');
    }
}
