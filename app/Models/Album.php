<?php

namespace App\Models;

/**
 * App\Models\Album
 *
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AlbumItem[] $items
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $order
 * @property string $type
 * @property string $title
 * @property string $description
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Album whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Album whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Album whereOrder($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Album whereType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Album whereTitle($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Album whereDescription($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Album whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Album whereUpdatedAt($value)
 */
class Album extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'user_id' => 'integer',
    ];

    /**
     * Boot model
     *
     * @return void
     */
    public static function boot()
    {
        parent::boot();

        // Delete all items on model delete
        static::deleting(function ($model) {
            foreach ($model->items as $item) {
                $item->delete();
            }
        });
    }


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * User that owns the profile
     */
    public function items()
    {
        return $this->hasMany(AlbumItem::class);
    }


    /* ========================================================================= *\
     * Other
    \* ========================================================================= */

    /**
     * Get cover image Url
     *
     * @return string
     */
    public function coverUrl()
    {
        $item = $this->items()->first();
        if ($item) {
            return $item->getFirstMediaUrl('default', 'thumb');
        }

        return 'http://placehold.it/200x200';
    }

    /**
     * Check if current album
     *
     * @param null $album
     * @return bool
     */
    public function current($album = null)
    {
        return $album && $album->id === $this->id;
    }

    /**
     * Is album mine
     *
     * @return bool
     */
    public function mine()
    {
        return $this->user_id === auth()->id();
    }

    /**
     * Get album Url
     */
    public function getUrl()
    {
        return url('albums/view/' . $this->id);
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
            'id'         => $this->id,
            'title'      => $this->title,
            'cover'      => url($this->coverUrl()),
            'created_at' => $this->created_at->toDateTimeString(),
            'can_update' => \Gate::allows('update', $this),
            'can_remove' => \Gate::allows('remove', $this),
        ];
    }
}
