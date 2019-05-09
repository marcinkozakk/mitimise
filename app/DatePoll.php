<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Date Poll model
 * 
 * Class DatePoll
 *
 * @package App
 * @property int $id
 * @property string $date
 * @property string|null $availability
 * @property int $user_id
 * @property int $meeting_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll whereAvailability($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll whereDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\DatePoll whereUserId($value)
 * @mixin \Eloquent
 */
class DatePoll extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'meeting_id', 'date'
    ];

    /**
     * return user who has answered in poll
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
