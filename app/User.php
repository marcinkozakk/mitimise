<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

/**
 * User model
 *
 * Class User
 * @package App
 */
class User extends Authenticatable implements MustVerifyEmail
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

    /**
     * Return circles that user is a creator of
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function circles() {
        return $this->hasMany('App\Circle');
    }

    /**
     * Return circles that user is a member of
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function memberCircles() {
        return $this->belongsToMany('App\Circle', 'memberships')
            ->where('circles.is_private', 0)
            ->where('circles.user_id', '!=', $this->id);
    }

    /**
     * Return meetings that user is an organizer of. Used for displaying on home page
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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

    /**
     * Return meetings that user is invited for. Used for displaying on home page
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
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

    /**
     * Delete user photo if exist, them save new photo path
     *
     * @param $path
     * @return null|string
     */
    public function setPhoto($path)
    {
        if(!empty($this->attributes['photo'])) {
            Storage::delete('public/' . $this->attributes['photo']);
        }
        $this->photo = $path;
        $this->save();

        return $this->photo;
    }

    /**
     * photo path getter
     *
     * @param $value
     * @return string
     */
    public function getPhotoAttribute($value)
    {
        if(empty($value)) return '/images/user-default.svg';
        return '/storage/' . $value;
    }
}
