<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CareerCategory extends Model
{
    public function courses()
    {
        return $this->hasMany('App\Course');
    }
}
