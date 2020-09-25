<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class wishlist extends Model
{
    protected $fillable = [
        'course_id',
        'user_id',
    ];

    public function courses()
    {
        return $this->belongsToMany(Course::class);
    }
    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

}
