<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Invitation model
 * 
 * Class Invitation
 *
 * @package App
 * @property int $id
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $meeting_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereUserId($value)
 * @mixin \Eloquent
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
