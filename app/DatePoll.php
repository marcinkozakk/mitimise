<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DatePoll extends Model
{
    protected $fillable = [
        'user_id', 'meeting_id', 'date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function circle() {
        return $this->belongsTo(Circle::class);
    }
}
