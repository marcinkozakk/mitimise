<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Meeting
 * @package App
 */
class Meeting extends Model
{
    /**
     * Return meeting guests with state pivot
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function guests()
    {
        return $this->belongsToMany('App\User', 'invitations')->withPivot('id', 'state');
    }

    /**
     * Return meeting organizer
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organizer()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Return meeting comments in reverse chronological order
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany('App\Comment')->orderBy('created_at', 'desc');
    }

}
