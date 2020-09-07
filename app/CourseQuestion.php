<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseQuestion extends Model
{
    protected $fillable = [
        'question',
        'course_materials_id',
        'optionA',
        'optionB',
        'optionC',
        'optionD',
        'answer',
    ];
    public function CourseMaterial()
    {
        return $this->belongsTo('App\CourseMaterials');
    }
}
