<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use CloudinaryLabs\CloudinaryLaravel\MediaAlly;

class Course extends Model
{
    use MediaAlly;

    protected $dates = [
        'converted_for_downloading_at',
        'converted_for_streaming_at',
    ];

    protected $fillable = [
        'title',
        'isApproved',
        'ApprovedBy',
        'courseCode',
        'videoUrl',
        'sub_category_id',
        'banner',
        'courseType',
        'isFree',
        'no_rated_user',
        'rating_percentage',
        'total_rating',
        'comment_id',
        'price',
        'objective',
        'tutor_id',
        'slug',
        'course_difficulty',
        'description',
    ];

    public function tutor()
    {
        return $this->belongsTo('App\Tutor');
    }

    public function Modules()
    {
        return $this->hasMany('App\CourseModule');
    }
    public function Reviews()
    {
        return $this->hasMany('App\Review');
    }
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
    public function SubCategory()
    {
        return $this->belongsTo('App\SubCategory');
    }
}
