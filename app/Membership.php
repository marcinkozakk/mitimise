<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Membership model
 * 
 * Class Membership
 *
 * @package App
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $circle_id
 * @property-read \App\Circle $circle
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereCircleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereUserId($value)
 * @mixin \Eloquent
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Return circle that refers to membership
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function circle() {
        return $this->belongsTo(Circle::class);
    }
}
