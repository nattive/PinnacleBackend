<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userCourseProgress extends Model
{
    protected $fillable = [
        'course_id',
        'module_id',
        'user_id',
        'consumed_materials_array',
        'finished',
    ];
}
