<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CourseCart extends Model
{
    protected $fillable = [
        'total'
    ];
    public function courseCartItems()
    {
        return $this-> belongsToMany(CourseCartItem::class);
    }

      public function user()
    {
        return $this-> belongsTo(User::class);
    }
}
