<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * Class User
 *
 * @package App\Models
 * @property-read \App\Models\UserProfile $profile
 * @property-read \App\Models\Media $picture
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Album[] $albums
 * @property-read \App\Models\Album $profile_album
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $profile_posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Like[] $likes
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\View[] $views
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Comment[] $comments
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Notification[] $notifications
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Chat[] $chats
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $friends
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $friends_requests
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $friends_sent_requests
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $friends_all
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $groups
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $groups_invites
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Group[] $groups_requests
 * @property-read mixed $full_name
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User online()
 * @mixin \Eloquent
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $remember_token
 * @property string $socket_token
 * @property string $api_token
 * @property \Carbon\Carbon $last_online
 * @property integer $picture_media_id
 * @property string $locale
 * @property string $options
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereName($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereEmail($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePassword($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereRememberToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereSocketToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereApiToken($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLastOnline($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User wherePictureMediaId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereLocale($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereOptions($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\User whereUpdatedAt($value)
 */
class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'last_online', 'picture_media_id', 'socket_token', 'api_token', 'locale', 'options'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['profile', 'picture'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['last_online'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'picture_media_id' => 'int',
        'options' => 'json',
    ];

    /**
     * Last activity minutes ago to consider user online
     *
     * @var int
     */
    protected $onlineMinutes = 5;


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * User's profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(UserProfile::class);
    }

    /**
     * Has profile picture
     */
    public function picture()
    {
        return $this->belongsTo(Media::class, 'picture_media_id');
    }

    /**
     * Has many albums
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function albums()
    {
        return $this->hasMany(Album::class);
    }

    /**
     * Has profile album
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile_album()
    {
        return $this->hasOne(Album::class)->where('type', 'profile');
    }

    /**
     * Has many posts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /**
     * Has many posts in profile
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function profile_posts()
    {
        return $this->hasMany(Post::class)
                    ->whereNull('group_id');
    }

    /**
     * Liked many items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    /**
     * Visited many items (visiting other's pages)
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function views()
    {
        return $this->hasMany(View::class);
    }

    /**
     * Commented many items
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    /**
     * Has many notifications
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    /**
     * Has many private chats
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function chats()
    {
        return $this->hasMany(Chat::class, 'user_one_id')
                    ->orWhere('user_two_id', $this->id)
                    ->orderBy('updated_at', 'DESC');
    }

    /**
     * Has many friends
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'accept');
    }

    /**
     * Has many friends requests
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends_requests()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'request');
    }

    /**
     * Has many sent friends requests
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends_sent_requests()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->wherePivot('status', 'requested');
    }

    /**
     * Has many friends with all statuses
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function friends_all()
    {
        return $this->belongsToMany(User::class, 'friends', 'user_id', 'friend_id')
                    ->withPivot('status');
    }

    /**
     * Has one friend pivot record with current authenicated user
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function friend_pivot()
    {
        $user = auth()->user();

        return $this->hasOne(Friend::class)->where('friend_id', $user ? $user->id : 0);
    }

    /**
     * Has many groups
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class)
            ->wherePivot('status', 'accept')
            ->withTimestamps()
            ->withPivot(['type']);
    }

    /**
     * Has many groups invites
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups_invites()
    {
        return $this->belongsToMany(Group::class)
                    ->wherePivot('status', 'invite')
                    ->withTimestamps()
                    ->withPivot(['id', 'type']);
    }

    /**
     * Has many groups requests
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function groups_requests()
    {
        return $this->belongsToMany(Group::class)
                    ->wherePivot('status', 'request')
                    ->withTimestamps()
                    ->withPivot(['id', 'type']);
    }


    /* ========================================================================= *\
     * Scopes
    \* ========================================================================= */

    /**
     * Scope a query to get online users
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeOnline($query)
    {
        // Skip authenticated user
        if (auth()->id()) {
            $query->where('users.id', '!=', auth()->id());
        }

        return $query->where(
            'users.last_online',
            '>',
            Carbon::now()->subMinutes($this->onlineMinutes)->toDateTimeString()
        );
    }


    /* ========================================================================= *\
     * Attriubtes mutators
    \* ========================================================================= */

    /**
     * Get full_name attribute
     *
     * @return string
     */
    public function getFullNameAttribute()
    {
        return $this->profile->fullName();
    }


    /* ========================================================================= *\
     * Other data
    \* ========================================================================= */

    /**
     * Get user profile page URL
     */
    public function getUrl()
    {
        return url('profile/' . $this->id);
    }

    /**
     * If user is online
     *
     * @return bool
     */
    public function isOnline()
    {
        return Carbon::now()->diffInMinutes(new Carbon($this->last_online)) < $this->onlineMinutes;
    }


    /**
     * Is it me
     *
     * @return bool
     */
    public function isMe()
    {
        return auth()->id() === $this->id;
    }

    /**
     * Get friend record to specific user
     *
     * @param User $user
     */
    public function friend($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        return $this->friends_all()->where('friends.friend_id', $user->id)->first();
    }

    /**
     * Get friends of friends
     *
     * @param $user
     * @return mixed
     */
    public static function friendsOfFriends($user)
    {
        $ids = Friend::whereIn('user_id', function ($query) use ($user) {
            $query->from('friends')->select('friend_id')
                  ->where('status', 'accept')
                  ->where('user_id', $user->id);
        })->where('friend_id', '!=', $user->id)
            ->select('friend_id')->get()->pluck('friend_id');

        return self::whereIn('id', $ids)
            // Who is not friend already
            ->where(\DB::raw('0'), function ($query) use ($user) {
                $query->from('friends')->selectRaw('count(*)')
                      ->where('user_id', $user->id)
                      ->whereRaw('friend_id = users.id');
            });
    }

    /**
     * Get data for broadcasting
     */
    public function getBroadcastData()
    {
        return [
            'id'        => $this->id,
            'name'      => $this->name,
            'full_name' => $this->full_name,
            'image'     => $this->pictureUrl('thumb'),
            'url'       => url('profile/' . $this->id),
        ];
    }

    /**
     * Get option from options field
     *
     * @param      $name
     * @param null $default
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        return array_get($this->options, $name, $default);
    }


    /* ========================================================================= *\
     * Profile picture
    \* ========================================================================= */

    /**
     * Add new profile picture
     *
     * @param $file
     */
    public function addProfilePicture($file)
    {
        $album = $this->profile_album;

        // Create Profile pictures album
        if (! $album) {
            $album = $this->albums()->create([
                'type'  => 'profile',
                'title' => trans('albums.profile-pictures'),
            ]);
        }

        $item = $album->items()->create([]);
        $media = $item->addMedia($file)->toCollection();

        $this->update(['picture_media_id' => $media->id]);
    }

    /**
     * Set media as profile picture
     *
     * @param $media
     */
    public function setPictureAsProfile($media)
    {
        $this->update(['picture_media_id' => $media->id]);
    }

    /**
     * Get profile picture url
     *
     * @param $size
     * @return bool
     */
    public function pictureUrl($size = '')
    {
        if (! $this->picture) {
            return false;
        }

        return $this->picture->getUrl($size);
    }


    /* ========================================================================= *\
     * Data
    \* ========================================================================= */

    /**
     * Get short data
     *
     * @param array $add
     * @return array
     */
    public function getShortData($add = [])
    {
        $data = [
            'id'            => $this->id,
            'name'          => $this->name,
            'picture_thumb' => url($this->pictureUrl('thumb')),
            'full_name'     => $this->full_name,
            'friend_status' => $this->friend_pivot ? $this->friend_pivot->status : null,
        ];

        return array_merge($data, $add);
    }

    /**
     * Get list data
     *
     * @param array $add
     * @return array
     */
    public function getListData($add = [])
    {
        $data = [
            'id'            => $this->id,
            'name'          => $this->name,
            'picture_thumb' => url($this->pictureUrl('thumb')),
            'full_name'     => $this->full_name,
            'profile'       => $this->profile->getListData(),
            'friend_status' => $this->friend_pivot ? $this->friend_pivot->status : null,
        ];
        
        return array_merge($data, $add);
    }
    
    /**
     * Get public data
     */
    public function getPublicData()
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->getOption('hide_email') ? null : $this->email,
            'picture_thumb' => url($this->pictureUrl('thumb')),
            'picture'       => url($this->pictureUrl()),
            'full_name'     => $this->full_name,
            'profile'       => $this->profile->getPublicData(),
            'friend_status' => $this->friend_pivot ? $this->friend_pivot->status : null,
        ];
    }

    /**
     * Get full data
     */
    public function getFullData()
    {
        return [
            'id'            => $this->id,
            'name'          => $this->name,
            'email'         => $this->email,
            'picture_thumb' => url($this->pictureUrl('thumb')),
            'picture'       => url($this->pictureUrl()),
            'full_name'     => $this->full_name,
            'profile'       => $this->profile->getFullData(),
            'options'       => $this->options,
        ];
    }
}
