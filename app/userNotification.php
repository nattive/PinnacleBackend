<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userNotification extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'body',
        'isRead',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
