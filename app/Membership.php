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
        return $this->hasOne(User::class);
    }

    public function circle() {
        return $this->hasOne(Circle::class);
    }
}
