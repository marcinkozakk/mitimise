<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;
use NotificationChannels\WebPush\HasPushSubscriptions;

/**
 * User model
 * 
 * Class User
 *
 * @package App
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string $photo
 * @property string|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $remember_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Circle[] $circles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Meeting[] $meetings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Meeting[] $meetingsInvited
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Circle[] $memberCircles
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property string|null $facebook_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereFacebookId($value)
 * @property-read \Illuminate\Database\Eloquent\Collection|\NotificationChannels\WebPush\PushSubscription[] $pushSubscriptions
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Meeting[] $placesVisited
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Meeting[] $pastMeetings
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Meeting[] $incomingMeetings
 */
class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, HasPushSubscriptions;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'email_verified_at',
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
     * Returns places
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function pastMeetings()
    {
        return $this->belongsToMany('App\Meeting', 'invitations')
            ->wherePivot('state', 'going')
            ->where('is_canceled', 0)
            ->where('ends_at', '<', Carbon::now())
            ->orderBy('ends_at')
            ->with('place');
    }

    public function incomingMeetings()
    {
        return $this->belongsToMany('App\Meeting', 'invitations')
            ->where('is_canceled', 0)
            ->where('ends_at', '>', Carbon::now())
            ->orWhereNull('ends_at');
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
