<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Circle model
 * 
 * Class Circle
 *
 * @package App
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_private
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $members
 * @property-read \App\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereUserId($value)
 * @mixin \Eloquent
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
