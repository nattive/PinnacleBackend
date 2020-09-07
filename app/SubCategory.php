<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubCategory extends Model
{
    protected $fillable = [
        'main_category_id',
        'name',
    ];

    public function MainCategory()
    {
        return $this->belongsTo('App\MainCategory');
    }

    public function courses()
    {
        return $this->hasMany('App\Course');
    }
}
