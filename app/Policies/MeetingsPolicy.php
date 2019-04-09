<?php

namespace App\Policies;

use App\Meeting;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

/**
 * This policy is responsible for organizing authorization logic around meetings actions
 *
 * Class MeetingsPolicy
 * @package App\Policies
 */
class MeetingsPolicy
{
    use HandlesAuthorization;

    /**
     * Check if user is authorized to view meeting
     *
     * @param User $user
     * @param Meeting $meeting
     * @return bool
     */
    public function show(User $user, Meeting $meeting)
    {
        return $meeting->guests->contains('id', $user->id);
    }

    /**
     * Check if user is authorized to view meeting guests
     *
     * @param User $user
     * @param Meeting $meeting
     * @return bool
     */
    public function viewGuests(User $user, Meeting $meeting)
    {
        return !$meeting->is_private || $meeting->organizer_id == $user->id;
    }

    /**
     * Check if user is authorized to edit meeting
     *
     * @param User $user
     * @param Meeting $meeting
     * @return bool
     */
    public function edit(User $user, Meeting $meeting)
    {
        return $meeting->organizer_id == $user->id && !$meeting->is_canceled;
    }

    /**
     * Check if user is authorized to change state of invitation for meeting
     *
     * @param User $user
     * @param Meeting $meeting
     * @return bool
     */
    public function setState(User $user, Meeting $meeting)
    {
        return $meeting->organizer_id != $user->id && $meeting->guests->contains('id', $user->id) && !$meeting->is_canceled;
    }
}
