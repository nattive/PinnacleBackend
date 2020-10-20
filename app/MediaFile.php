<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MediaFile extends Model
{
    protected $fillable = [
        'name',
        'type',
        'link',
        'caption',
        'streamLink',
        'course_id',
        'blog_category_id',
        'free_resources_id',
    ];
}
