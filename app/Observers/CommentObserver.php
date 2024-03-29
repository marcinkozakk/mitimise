<?php

namespace App\Observers;

use App\Comment;
use App\Notifications\DefaultNotification;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

/**
 * Class responsible for comment's events observation
 *
 * Class CommentObserver
 * @package App\Observers
 */
class CommentObserver
{
    /**
     * Handle the comment "created" event.
     *
     * @param  \App\Comment  $comment
     * @return void
     */
    public function created(Comment $comment)
    {
        Notification::send(
            User::findMany(
                Comment::where(['meeting_id' => $comment->meeting->id])
                    ->where('user_id', '!=', Auth::id())
                    ->where('user_id', '!=', $comment->meeting->organizer_id)
                    ->get('user_id')
                    ->toArray()
            ),
            new DefaultNotification([
                'text' => ':doer also commented ":target"',
                'doer' => Auth::user()->name,
                'target' => $comment->meeting->name,
                'icon' => 'comment',
                'redirectTo' => route('meetings.show', ['id' => $comment->meeting_id], false) . '#comments'
            ])
        );

        if($comment->meeting->organizer_id != Auth::id())
        Notification::send(
            $comment
                ->meeting
                ->organizer,
            new DefaultNotification([
                'text' => ':doer commented on ":target"',
                'doer' => \Auth::user()->name,
                'target' => $comment->meeting->name,
                'icon' => 'comment',
                'redirectTo' => route('meetings.show', ['id' => $comment->meeting_id], false) . '#comments'
            ])
        );
    }
}
