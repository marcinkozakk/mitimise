<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Circle model
 *
 * Class Circle
 * @package App
 */
class Circle extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'is_private',
    ];

    /**
     * Return owner of circe
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    /**
     * Return members in reverse chronological order
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function members() {
        return $this->belongsToMany('App\User', 'memberships')->orderBy('memberships.created_at', 'desc');
    }
}
