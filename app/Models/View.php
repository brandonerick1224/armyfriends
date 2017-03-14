<?php

namespace App\Models;

/**
 * App\Models\View
 *
 * @property-read \App\Models\User $user
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $viewable
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $viewable_id
 * @property string $viewable_type
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\View whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\View whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\View whereViewableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\View whereViewableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\View whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\View whereUpdatedAt($value)
 */
class View extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];


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
     * Get owning commentable model
     */
    public function viewable()
    {
        return $this->morphTo();
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
            'user'       => $this->user->getShortData(),
            'created_at' => $this->created_at->toDateTimeString(),
        ];
    }
}
