<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Volunteer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'motivation',
        'Interest',
        'Availability',
        'Educational',
        'tool',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
