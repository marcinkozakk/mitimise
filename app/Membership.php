<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Membership model
 *
 * Class Membership
 * @package App
 */
class Membership extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'circle_id',
    ];

    /**
     * Return user who is a member
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App/User');
    }

    /**
     * Return circle that refers to membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function circle() {
        return $this->hasOne('App/Circle');
    }
}
