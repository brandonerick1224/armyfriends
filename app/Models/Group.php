<?php

namespace App\Models;

use App\Events\NotificationEvent;
use Spatie\MediaLibrary\HasMedia\HasMediaTrait;
use Spatie\MediaLibrary\HasMedia\Interfaces\HasMediaConversions;

/**
 * App\Models\Group
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $admins
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $requests
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $invitations
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\User[] $users_all
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Post[] $posts
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Media[] $media
 * @mixin \Eloquent
 * @property integer $id
 * @property string $type
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Group whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Group whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Group whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Group whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Group whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Group whereUpdatedAt($value)
 */
class Group extends Model implements HasMediaConversions
{
    use HasMediaTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * Group users cache
     *
     * @var array
     */
    protected $group_users = [];

    /**
     * Boot model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // Delete all posts on model delete
        static::deleting(function ($model) {
            foreach ($model->posts as $post) {
                $post->delete();
            }
        });
    }


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Have joined users
     */
    public function users()
    {
        return $this->belongsToMany(User::class)
                    ->wherePivot('status', 'accept')
                    ->withTimestamps()
                    ->withPivot(['id', 'type']);
    }

    /**
     * Have admins
     */
    public function admins()
    {
        return $this->belongsToMany(User::class)
                    ->wherePivot('status', 'accept')
                    ->wherePivot('type', 'admin');
    }

    /**
     * Have users requests
     */
    public function requests()
    {
        return $this->belongsToMany(User::class)
                    ->wherePivot('status', 'request')
                    ->withTimestamps()
                    ->withPivot(['id', 'type']);
    }

    /**
     * Have users invitations
     */
    public function invitations()
    {
        return $this->belongsToMany(User::class)
                    ->wherePivot('status', 'invite')
                    ->withTimestamps()
                    ->withPivot(['id', 'type']);
    }

    /**
     * Have all users and requests
     */
    public function users_all()
    {
        return $this->belongsToMany(User::class)
                    ->withTimestamps()
                    ->withPivot(['id', 'type', 'status']);
    }

    /**
     * Have users
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

    /**
     * Media files conversion
     */
    public function registerMediaConversions()
    {
        $this->addMediaConversion('thumb')
             ->setManipulations(['w' => 250, 'h' => 250, 'fit' => 'crop'])
             ->performOnCollections('cover');
    }

    /**
     * Get group user relation
     *
     * @param User|null $user
     * @return mixed
     */
    public function groupUser(User $user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        if (isset($this->group_users[$user->id])) {
            return $this->group_users[$user->id];
        }

        return $this->group_users[$user->id] = GroupUser::where(['user_id' => $user->id, 'group_id' => $this->id])->first();
    }

    /**
     * If user is admin for the group
     *
     * @param User  $user
     * @return bool
     * @internal param null $user
     */
    public function isAdmin(User $user = null)
    {
        $groupUser = $this->groupUser($user);
        return $groupUser && $groupUser->status === 'accept' && $groupUser->type === 'admin';
    }

    /**
     * If user in group
     *
     * @param User  $user
     * @return bool
     */
    public function inGroup(User $user = null)
    {
        $groupUser = $this->groupUser($user);
        return $groupUser && $groupUser->status === 'accept';
    }

    /**
     * Notify group admins
     *
     * @param $object
     */
    public function notifyAdmins($object)
    {
        foreach ($this->admins as $user) {
            event(new NotificationEvent($object, $user));
        }
    }

    /**
     * Get group page Url
     */
    public function getUrl()
    {
        return url('groups/view/' . $this->id);
    }
    
    
    /* ========================================================================= *\
     * Data
    \* ========================================================================= */

    /**
     * Get list data
     */
    public function getListData()
    {
        return [
            'id'          => $this->id,
            'type'        => $this->type,
            'title'       => $this->title,
            'cover_thumb' => url($this->getFirstMediaUrl('cover', 'thumb')),
            'created_at'  => $this->created_at->toDateTimeString(),
            'group_user'  => $this->groupUser() ? $this->groupUser()->getShortData() : null,
        ];
    }

    /**
     * Get public data
     */
    public function getPublicData()
    {
        $data = $this->getListData();
        $data['cover'] = url($this->getFirstMediaUrl('cover'));
        $data['description'] = $this->description;
        $data['users'] = $this->users->map(function (User $user) {
            return $user->getShortData(['group_user' => [
                'id' => $user->pivot->id,
                'type' => $user->pivot->type,
            ]]);
        });

        return $data;
    }

    /**
     * Get full data
     */
    public function getFullData()
    {
        $data = $this->getPublicData();
        $data['invitations'] = $this->invitations->map(function (User $user) {
            return $user->getShortData(['group_user' => [
                'id' => $user->pivot->id,
                'created_at' => $user->pivot->created_at->toDateTimeString(),
            ]]);
        });
        $data['requests'] = $this->requests->map(function (User $user) {
            return $user->getShortData(['group_user' => [
                'id' => $user->pivot->id,
                'created_at' => $user->pivot->created_at->toDateTimeString(),
            ]]);
        });

        return $data;
    }
}
