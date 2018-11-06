<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    protected $fillable = [
        'name', 'is_private',
    ];

    public function user()
    {
        return $this->hasOne('App/User');
    }
}
