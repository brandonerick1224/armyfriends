<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Subscription
 *
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $subscribable
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription active()
 * @mixin \Eloquent
 * @property integer $id
 * @property integer $user_id
 * @property integer $subscribable_id
 * @property string $subscribable_type
 * @property boolean $active
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereUserId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereSubscribableId($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereSubscribableType($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereActive($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|\App\Models\Subscription whereUpdatedAt($value)
 */
class Subscription extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id', 'subscribable_id', 'subscribable_type'];


    /* ========================================================================= *\
     * Relations
    \* ========================================================================= */

    /**
     * Get owning subscribable model
     */
    public function subscribable()
    {
        return $this->morphTo();
    }

    /**
     * Like belongs to user
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get liked item Url
     */
    public function getUrl()
    {
        return $this->subscribable->getUrl();
    }


    /* ========================================================================= *\
     * Scopes
    \* ========================================================================= */

    /**
     * Scope a query to get active subscriptions
     *
     * @param Builder $query
     * @return Builder
     */
    public function scopeActive($query)
    {
        return $query->where('subscriptions.active', 1);
    }
}
