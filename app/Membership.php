<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [
        'user_id', 'circle_id',
    ];

    public function user()
    {
        return $this->hasOne('App/User');
    }

    public function circle() {
        return $this->hasOne('App/Circle');
    }
}
