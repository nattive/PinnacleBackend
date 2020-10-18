<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'course_id',
        'blog_posts_id',
        'body',
     ];

    public function course()
    {
        return $this->belongsTo('App\Course', 'course_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
 public function replies()
    {
        return $this->hasMany('App\Reply');
    }

}
