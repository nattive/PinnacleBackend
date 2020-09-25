<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseMaterials extends Model
{


    protected $fillable = [
        'title',
        'course_module_id',
        'stepInModule',
        'text',
        'quiz',
        'objective',
        'prerequisite',
        'duration',
        'public_id',
        'videoPath',
        'images',
    ];
    public function Module()
    {
        return $this->belongsTo('App\CourseModule', 'course_module_id');
    }
    public function CourseQuestions()
    {
        return $this->hasMany('App\CourseQuestion');
    }

}
