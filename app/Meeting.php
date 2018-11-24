<?php

namespace App;

use Carbon\Carbon;
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

    public function getDatePollsAttribute()
    {
        $dates = DatePoll::where('meeting_id', $this->id)
            ->where('date', '>=', Carbon::now())
            ->select('date')
            ->selectRaw('sum(case availability when \'yes\' then 1 else 0 end) as available')
            ->selectRaw('sum(case availability when \'no\' then 1 else 0 end) as not_available')
            ->groupBy('date')
            ->orderBy('available', 'desc')
            ->orderBy('not_available', 'asc')
            ->get();

        foreach ($dates as $i => $date) {
            $dates[$i]['polls'] = DatePoll::where('date', $date->date)
                ->where('availability', '!=', 'null')
                ->orderBy('availability')
                ->get();
        }

        return $dates;
    }

}
