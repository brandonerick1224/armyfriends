<?php

namespace App\Models;

use App\Models\Traits\Commentable;
use App\Models\Traits\Likeable;
use App\Models\Traits\Notificable;
use App\Models\Traits\Viewable;

/**
 * App\Models\UserProfile
 *
 * @property-read \App\Models\User $user
 * @property-read \App\Models\Country $country
 * @property-read \App\Models\Country $service_country
 * @property-read mixed $full_name
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\View[] $views
 * @property-read mixed $viewable_type
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read mixed $liked
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereViewedBy($userId = null)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereLikedBy($userId = null)
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $picture_media_id
 * @property string $first_name
 * @property string $last_name
 * @property integer $country_id
 * @property string $city
 * @property \Carbon\Carbon $birth_date
 * @property \Carbon\Carbon $service_start_date
 * @property \Carbon\Carbon $service_end_date
 * @property integer $service_country_id
 * @property string $service_city
 * @property string $about_me
 * @property integer $views_count
 * @property integer $likes_count
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile wherePictureMediaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereFirstName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereLastName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereBirthDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereServiceStartDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereServiceEndDate($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereServiceCountryId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereServiceCity($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereAboutMe($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereViewsCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereLikesCount($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\UserProfile whereUpdatedAt($value)
 */
class UserProfile extends Model
{
    use Viewable, Likeable, Notificable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['birth_date', 'service_start_date', 'service_end_date'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * User that owns the profile
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Has country
     */
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    /**
     * Has service country
     */
    public function service_country()
    {
        return $this->belongsTo(Country::class, 'service_country_id');
    }


    /* ========================================================================= *\
     * Other data
    \* ========================================================================= */

    /**
     * Get full_name attribute
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->fullName();
    }

    /**
     * Get full name
     *
     * @return string
     */
    public function fullName()
    {
        return $this->first_name . ' ' . $this->last_name;
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

    /**
     * Is profile mine
     *
     * @return bool
     */
    public function mine()
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Get user profile page URL
     */
    public function getUrl()
    {
        return url('profiles/' . $this->id);
    }


    /* ========================================================================= *\
     * Data
    \* ========================================================================= */

    /**
     * Get short data
     */
    public function getShortData()
    {
        return [
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
        ];
    }

    /**
     * Get list data
     */
    public function getListData()
    {
        return [
            'user_id'    => $this->user_id,
            'first_name' => $this->first_name,
            'last_name'  => $this->last_name,
            'country'    => $this->country->name,
            'city'       => $this->city,
        ];
    }

    /**
     * Get public data
     */
    public function getPublicData()
    {
        return [
            'user_id'            => $this->user_id,
            'first_name'         => $this->first_name,
            'last_name'          => $this->last_name,
            'country'            => $this->country->name,
            'city'               => $this->city,
            'service_start_date' => (string) $this->service_start_date,
            'service_end_date'   => (string) $this->service_end_date,
            'service_country'    => $this->service_country->name,
            'service_city'       => $this->service_city,
            'about_me'           => $this->about_me,
            'liked'              => $this->liked(),
        ];
    }

    /**
     * Get full data
     */
    public function getFullData()
    {
        $data = $this->getPublicData();
        $data['birth_date'] = $this->birth_date->toDateString();

        return $data;
    }
}
