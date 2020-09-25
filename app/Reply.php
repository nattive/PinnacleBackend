<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'user_id',
        'tutor_id',
        'comment_id',
        'body',
        'admin_id',
    ];
    public function Comment()
    {
        return $this->belongsTo('App\Comment', 'comment_id');
    }
      public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
