<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userCourseProgress extends Model
{
    protected $fillable = [
        'module_id',
        'course_id', //the course relation
        'user_id', // Associated  User
        'current', // The current status of the user in the course
        'total_module',// The total module in the course
        'average_score', // All quizzes score attained by user divided by attainable score * 100
        'finished', //set true if user has completed the course
        'remark', // Other additional remarks/information
    ];
    /**
     * This model handles the user progress of a course.
     *
     */
    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
