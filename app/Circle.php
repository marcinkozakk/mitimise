<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Circle extends Model
{
    protected $fillable = [
        'name', 'is_private',
    ];

    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function members() {
        return $this->belongsToMany('App\User', 'memberships')->orderBy('memberships.created_at', 'desc');
    }
}
