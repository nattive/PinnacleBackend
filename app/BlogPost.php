<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    protected $fillable = [
        'blog_category_id',
        'tags',
        'imageUrl',
        'mediaType',
        'title',
        'body',
        'slug',
        'admin_id',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class, 'blog_posts_id');
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function BlogCategory()
    {
        return $this->belongsTo(BlogCategory::class);
    }
}
