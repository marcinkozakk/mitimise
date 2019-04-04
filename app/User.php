<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Storage;

/**
 * App\User
 *
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

    public function circles() {
        return $this->hasMany('App\Circle');
    }

    public function memberCircles() {
        return $this->belongsToMany('App\Circle', 'memberships')
            ->where('circles.is_private', 0)
            ->where('circles.user_id', '!=', $this->id);
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
