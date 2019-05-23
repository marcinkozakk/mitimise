<?php

namespace App\Observers;

use App\Meeting;
use App\Notifications\DefaultNotification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

/**
 * Class responsible for meeting's events observation
 *
 * Class MeetingObserver
 * @package App\Observers
 */
class MeetingObserver
{
    /**
     * Handle the meeting "updated" event.
     *
     * @param  \App\Meeting  $meeting
     * @return void
     */
    public function updated(Meeting $meeting)
    {
        Notification::send(
            $meeting
                ->guests()
                ->where('user_id', '!=', Auth::id())
                ->get(),
            new DefaultNotification([
                'text' => ':doer updated details about ":target"',
                'doer' => Auth::user()->name,
                'target' => $meeting->name,
                'icon' => 'highlighter',
                'redirectTo' => route('meetings.show', ['id' => $meeting->id], false)
            ])
        );
    }

}
