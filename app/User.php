<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function circles() {
        return $this->hasMany('App\Circle');
    }

    public function memberCircles() {
        return $this->belongsToMany('App\Circle', 'memberships')
            ->where('circles.is_private', 0)
            ->where('circles.user_id', '!=', $this->id);
    }

    public function meetings() {
        return $this->hasMany('App\Meeting', 'organizer_id')
            ->where('is_canceled', 0)                                           // not canceled
            ->where(function($q) {                                              // AND
                $q->where('ends_at', '>', Carbon::now())                        // not ended
                    ->orWhere(function($q) {                                    // OR
                        $q->whereNull('ends_at')                                // (ends_at is Null
                            ->where(function ($q) {                             // AND
                                $q->where('starts_at', '>', Carbon::now())      // {not started
                                    ->orWhereNull('starts_at');                 // OR starts_at is Null})
                            });
                    });
            })
            ->orderBy('starts_at');
    }

    public function meetingsInvited() {
        return $this->belongsToMany('App\Meeting', 'invitations')
            ->where('meetings.organizer_id', '!=', $this->id)                     // not yours meetings
            ->where('is_canceled', 0)                                           // AND not canceled
            ->where(function($q) {                                              // AND
                $q->where('ends_at', '>', Carbon::now())                        // not ended
                    ->orWhere(function($q) {                                    // OR
                        $q->whereNull('ends_at')                                // (ends_at is Null
                            ->where(function ($q) {                             // AND
                                $q->where('starts_at', '>', Carbon::now())      // {not started
                                    ->orWhereNull('starts_at');                 // OR starts_at is Null})
                            });
                    });
            })
            ->orderBy('starts_at')
            ->withPivot('state');
    }

    public function setPhoto($path)
    {
        if(!empty($this->photo)) {
            Storage::delete('public/' . $this->attributes['photo']);
        }
        $this->photo = $path;
        $this->save();

        return $this->photo;
    }

    public function getPhotoAttribute($value)
    {
        if(empty($value)) return '/images/user-default.svg';
        return '/storage/' . $value;
    }
}
