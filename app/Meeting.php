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

}
