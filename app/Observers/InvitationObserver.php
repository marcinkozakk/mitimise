<?php

namespace App\Observers;

use App\Invitation;
use App\Notifications\DefaultNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

/**
 * Class responsible for invitation's events observation
 *
 * Class InvitationObserver
 * @package App\Observers
 */
class InvitationObserver
{
    /**
     * Handle the invitation "created" event.
     *
     * @param  \App\Invitation  $invitation
     * @return void
     */
    public function created(Invitation $invitation)
    {
        if($invitation->user_id != Auth::id()) {
            Notification::send($invitation->user, new DefaultNotification([
                'text' => ':doer invited you to ":target"',
                'doer' => Auth::user()->name,
                'target' => $invitation->meeting->name,
                'icon' => 'handshake',
                'redirectTo' => route('meetings.show', ['id' => $invitation->meeting_id], false)
            ]));
        }
    }

    /**
     * Handle the invitation "updated" event.
     *
     * @param  \App\Invitation  $invitation
     * @return void
     */
    public function updated(Invitation $invitation)
    {
        Notification::send($invitation->meeting->organizer, new DefaultNotification([
            'text' => $invitation->state == 'going' ? ':doer is going to ":target"' : ':doer is undecided about going to ":target"',
            'doer' => $invitation->user->name,
            'target' => $invitation->meeting->name,
            'icon' => $invitation->state == 'going' ? 'calendar-check' : 'calendar',
            'redirectTo' => route('meetings.show', ['id' => $invitation->meeting_id], false)
        ]));
    }

    /**
     * Handle the invitation "deleted" event.
     *
     * @param  \App\Invitation  $invitation
     * @return void
     */
    public function deleted(Invitation $invitation)
    {
        Notification::send($invitation->meeting->organizer, new DefaultNotification([
            'text' => ':doer can\'t go to ":target"',
            'doer' => $invitation->user->name,
            'target' => $invitation->meeting->name,
            'icon' => 'calendar-times',
            'redirectTo' => route('meetings.show', ['id' => $invitation->meeting_id], false)
        ]));
    }
}
