<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    public function guests()
    {
        return $this->belongsToMany('App\User', 'invitations')->withPivot('id', 'state');
    }

    public function organizer()
    {
        return $this->belongsTo('App\User');
    }

    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

}
