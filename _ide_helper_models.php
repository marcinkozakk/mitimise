<?php

// @formatter:off
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App{
/**
 * App\Meeting
 *
 * @property int $id
 * @property string $name
 * @property string|null $starts_at
 * @property string|null $ends_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string $description
 * @property int $is_private
 * @property int $is_canceled
 * @property int $organizer_id
 * @property int|null $place_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $guests
 * @property-read \App\User $organizer
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereEndsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereIsCanceled($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereOrganizerId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting wherePlaceId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereStartsAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Meeting whereUpdatedAt($value)
 */
	class Meeting extends \Eloquent {}
}

namespace App{
/**
 * App\User
 *
 * @property int $id
 * @property string $email
 * @property string $password
 * @property string $name
 * @property string|null $photo
 * @property string|null $email_verified_at
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property string|null $remember_token
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Circle[] $circles
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Circle[] $memberCircles
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User wherePhoto($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\User whereUpdatedAt($value)
 */
	class User extends \Eloquent {}
}

namespace App{
/**
 * App\Circle
 *
 * @property int $id
 * @property string $name
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_private
 * @property int $user_id
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\User[] $members
 * @property-read \App\User $owner
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Circle whereUserId($value)
 */
	class Circle extends \Eloquent {}
}

namespace App{
/**
 * App\Membership
 *
 * @property int $id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $circle_id
 * @property-read \App\Circle $circle
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereCircleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Membership whereUserId($value)
 */
	class Membership extends \Eloquent {}
}

namespace App{
/**
 * App\Comment
 *
 * @property int $id
 * @property string $content
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $meeting_id
 * @property int $user_id
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereContent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Comment whereUserId($value)
 */
	class Comment extends \Eloquent {}
}

namespace App{
/**
 * App\Invitation
 *
 * @property int $id
 * @property string $state
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $user_id
 * @property int $meeting_id
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereMeetingId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereState($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Invitation whereUserId($value)
 */
	class Invitation extends \Eloquent {}
}

