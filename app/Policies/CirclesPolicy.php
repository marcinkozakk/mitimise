<?php

namespace App\Policies;

use App\Circle;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CirclesPolicy
{
    use HandlesAuthorization;

    public function show(User $user, Circle $circle)
    {
        return $user->id === $circle->user_id || (!$circle->is_private && $circle->members->contains('id', $user->id));
    }

    public function edit(User $user, Circle $circle)
    {
        return $user->id === $circle->user_id;
    }
}
