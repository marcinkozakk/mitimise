<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Invitation model
 *
 * Class Invitation
 * @package App
 */
class Invitation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'state', 'meeting_id'
    ];

    /**
     * Create invitations from given array
     *
     * @param array $users_id
     * @param $meeting_id
     * @throws \Throwable
     */
    public static function createInvitations($users_id, $meeting_id) {
        foreach($users_id as $user_id) {
            $invitation = Invitation::firstOrNew([
                'user_id' => $user_id,
                'meeting_id' => $meeting_id
            ]);
            if($invitation->state != 'going') {
                $invitation->state = 'undecided';
            }

            $invitation->saveOrFail();
        }
    }
}
