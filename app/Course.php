<?php

namespace App;

use CloudinaryLabs\CloudinaryLaravel\MediaAlly;
use Illuminate\Database\Eloquent\Model;
use Spatie\Searchable\Searchable;
use Spatie\Searchable\SearchResult;

class Course extends Model  implements Searchable
{
    use MediaAlly;

    protected $dates = [
        'converted_for_downloading_at',
        'converted_for_streaming_at',
    ];

     public function getSearchResult(): SearchResult
     {

         return new \Spatie\Searchable\SearchResult(
            $this,
            $this->title,
            $this->subTitle,
              ['type' => 'course']
         );
     }

    protected $fillable = [
        'title',
        'subtitle',
        'isApproved',
        'ApprovedBy',
        'courseCode',
        'videoUrl',
        'image_public_id',
        'video_public_id',
        'sub_category_id',
        'banner',
        'courseType',
        'career_category_id',
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
        'prerequisite',
        'duration',
        'public_id',
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
    public function CareerCategory()
    {
        return $this->belongsTo('App\CareerCategory');
    }
    public function Comments()
    {
        return $this->hasMany('App\Comment');
    }

}
