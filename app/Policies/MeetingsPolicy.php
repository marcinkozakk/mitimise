<?php

namespace App\Policies;

use App\Comment;
use App\Meeting;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeetingsPolicy
{
    use HandlesAuthorization;

    //show meeting
    public function show(User $user, Meeting $meeting)
    {
        return $meeting->guests->contains('id', $user->id);
    }

    //view meeting guests
    public function viewGuests(User $user, Meeting $meeting)
    {
        return !$meeting->is_private || $meeting->organizer_id == $user->id;
    }

    //edit meeting and define date poll
    public function edit(User $user, Meeting $meeting)
    {
        return $meeting->organizer_id == $user->id && !$meeting->is_canceled;
    }

    //set your state
    public function setState(User $user, Meeting $meeting)
    {
        return $meeting->organizer_id != $user->id && $meeting->guests->contains('id', $user->id) && !$meeting->is_canceled;
    }

    //set your availability
    public function setAvailability(User $user, Meeting $meeting)
    {
        return $meeting->guests->contains('id', $user->id) && !$meeting->is_canceled;
    }

    //comment meeting
    public function comment(User $user, Meeting $meeting)
    {
        return $meeting->guests->contains('id', $user->id) && !$meeting->is_canceled;
    }

    //delete comment
    public function deleteComment(User $user, Meeting $meeting, Comment $comment) {
        return $meeting->organizer_id == $user->id || $comment->user_id == $user->id;
    }

    //revert canceled meeting
    public function revertCancelation(User $user, Meeting $meeting)
    {
        return $meeting->organizer_id == $user->id && $meeting->is_canceled;
    }
}
