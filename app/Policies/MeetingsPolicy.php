<?php

namespace App\Policies;

use App\Comment;
use App\Meeting;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class MeetingsPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Meeting $meeting)
    {
        return $meeting->guests->contains('id', $user->id);
    }

    public function viewGuests(User $user, Meeting $meeting)
    {
        return !$meeting->is_private || $meeting->organizer_id == $user->id;
    }

    public function edit(User $user, Meeting $meeting)
    {
        return $meeting->organizer_id == $user->id && !$meeting->is_canceled;
    }

    public function setState(User $user, Meeting $meeting)
    {
        return $meeting->organizer_id != $user->id && $meeting->guests->contains('id', $user->id) && !$meeting->is_canceled;
    }

    public function comment(User $user, Meeting $meeting)
    {
        return $meeting->guests->contains('id', $user->id) && !$meeting->is_canceled;
    }

    public function deleteComment(User $user, Meeting $meeting, Comment $comment) {
        return $meeting->organizer_id == $user->id || $comment->user_id == $user->id;
    }

    public function revertCancelation(User $user, Meeting $meeting)
    {
        return $meeting->organizer_id == $user->id && $meeting->is_canceled;
    }
}
