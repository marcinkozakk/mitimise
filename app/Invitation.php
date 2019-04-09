<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'user_id', 'state', 'meeting_id'
    ];

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
