<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserQuizResult extends Model
{
    protected $fillable = [
        'module_id',
        'no_correct_answer',
        'no_wrong_answer',
        'totalNumberOfQuestions',
        'total',
        'percentage',
        'user_id',
        'user_course_progress',
    ];

    public function CourseMaterial(){
        return $this->hasOne(CourseMaterials::class, 'module_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
