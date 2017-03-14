<?php

namespace App\Models\Traits;

use App\Models\Subscription;
use App\Models\User;

trait Subscribable
{
    /**
     * Should be removed on model delete
     *
     * @var bool
     */
    protected static $removeSubscriptionsOnDelete = true;

    /**
     * Boot the soft taggable trait for a model.
     *
     * @return void
     */
    public static function bootSubscribable()
    {
        if (static::$removeSubscriptionsOnDelete) {
            static::deleting(function ($model) {
                $model->removeSubscriptions();
            });
        }
    }

    /**
     * Delete likes related to the current record
     */
    public function removeSubscriptions()
    {
        foreach ($this->subscriptions as $subscription) {
            $subscription->delete();
        }
    }

    /**
     * Collection of the subscriptions on this record
     */
    public function subscriptions()
    {
        return $this->morphMany(Subscription::class, 'subscribable');
    }

    /**
     * Subscribed users
     */
    public function subscribers()
    {
        return $this->morphToMany(User::class, 'subscribable', 'subscriptions', 'subscribable_id')
                    ->wherePivot('active', 1);
    }

    /**
     * Add a subscription for this record by the given user.
     *
     * @param $user mixed - If null will use currently logged in user.
     * @return bool|Subscription
     * @throws
     */
    public function subscribe($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        // Don't subscribe owner
        if ($this->user_id === $user->id) {
            return false;
        }

        return $this->subscriptions()->firstOrCreate(['user_id' => $user->id]);
    }

    /**
     * Remove a subscription from this record for the given user.
     *
     * @param $user mixed - If null will use currently logged in user.
     * @throws
     */
    public function unsubscribe($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        $subscription = $this->subscriptions()->where('user_id', '=', $user->id)->first();

        if (! $subscription) {
            return;
        }

        $subscription->delete();
    }

    /**
     * Has the currently logged in user already "subscribed" for the current object
     *
     * @param string $user
     * @return boolean
     */
    public function subscribed($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        return (bool) $this->subscriptions()->where('user_id', '=', $user->id)->count();
    }

    /**
     * Activate subscription
     *
     * @param null $user
     */
    public function activateSubscription($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        $this->subscriptions()->where('user_id', '=', $user->id)->update(['active' => 1]);
    }

    /**
     * Deactivate subscription
     *
     * @param null $user
     */
    public function deactivateSubscription($user = null)
    {
        if (null === $user) {
            $user = auth()->user();
        }

        $this->subscriptions()->where('user_id', '=', $user->id)->update(['active' => 0]);
    }

    /**
     * Did the currently logged in user subscribed for this model
     *
     * @return boolean
     */
    public function getSubscribedAttribute()
    {
        return $this->subscribed();
    }
}
