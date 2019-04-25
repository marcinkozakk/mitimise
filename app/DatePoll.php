<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Date Poll model
 *
 * Class DatePoll
 * @package App
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
