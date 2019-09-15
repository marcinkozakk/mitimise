<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * App\Place
 *
 * @property int $id
 * @property string $name
 * @property string $address
 * @property float|null $lat
 * @property float|null $lng
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property int $is_private
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereAddress($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereIsPrivate($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereLat($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereLng($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Place whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read mixed $is_reviewed
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Review[] $reviews
 * @property-read mixed $user_review
 */
class Place extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'lat', 'lng', 'is_private'
    ];


    public function reviews()
    {
        return $this->hasMany('App\Review');
    }

    public function getIsReviewedAttribute()
    {
        return $this->reviews()
            ->where('user_id', Auth::id())
            ->where('place_id', $this->id)
            ->exists();
    }

    public function getUserReviewAttribute()
    {
        return $this->reviews()
            ->where('user_id', Auth::id())
            ->first();
    }

}
