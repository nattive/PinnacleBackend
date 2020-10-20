<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FreeResources extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'banner',
        'resource_category_id',
        'body',
        'slug',
        'user_id',
        'admin_id',
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function mediaFiles()
    {
        return $this->hasMany(MediaFile::class);
    }
  public function category()
    {
        return $this->belongsTo(freeResourceCategories::class, 'resource_category_id');
    }

}
