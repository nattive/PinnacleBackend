<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Mentee extends Model
{
    protected $fillable = [
        'name',
        'email',
        'motivation',
        'Interest',
        'Availability',
        'CoachPreference',
        'category',
    ];
      public function user()
    {
        return $this->belongsTo(User::class);
    }
}
