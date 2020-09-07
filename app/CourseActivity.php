<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseActivity extends Model
{
    protected $fillable = [
        'title',
        'body',
        'course_id',
        'user_id',
        'tutor_id',
    ];
    public function Tutor()
    {
        return $this->belongsTo(Tutor::class);
    }
}
