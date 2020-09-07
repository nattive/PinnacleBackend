<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseModule extends Model
{
    protected $fillable = [
        'title',
        'course_id',
    ];
    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }

    public function CourseMaterials()
    {
        return $this->hasMany('App\CourseMaterials');
    }
}
