<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Comment model
 *
 * Class Comment
 * @package App
 */
class Comment extends Model
{
    /**
     * Return user who has written the comment
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
