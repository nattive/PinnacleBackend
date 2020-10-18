<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class userMessage extends Model
{
    protected $fillable = [
        'From',
        'Subject',
        'isRead',
        'body',
        'user_id',
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
