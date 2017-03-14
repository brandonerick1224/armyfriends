<?php

namespace App\Models\Traits;

use App\Models\Notification;
use App\Models\User;

trait Notificable
{
    /**
     * Should be removed on model delete
     *
     * @var bool
     */
    protected static $removeNotificationsOnDelete = true;

    /**
     * Boot the soft taggable trait for a model.
     *
     * @return void
     */
    public static function bootNotificable()
    {
        if (static::$removeNotificationsOnDelete) {
            static::deleting(function ($model) {
                $model->removeNotifications();
            });
        }
    }

    /**
     * Delete notifications related to the current record
     */
    public function removeNotifications()
    {
        foreach ($this->notifications as $notification) {
            $notification->delete();
        }
    }

    /**
     * Get all of the model's notifications
     */
    public function notifications()
    {
        return $this->morphMany(Notification::class, 'notificable');
    }

    /**
     * Add a notification for this record for the given user.
     *
     * @param User $user
     * @param      $data
     */
    public function notify($user, $data = null)
    {
        $notification = $this->notifications()
                     ->where('user_id', '=', $user->id)
                     ->first();

        if ($notification) {
            $notification->update(['seen' => 0, 'data' => $data]);
            return;
        }

        $this->notifications()->create(['user_id' => $user->id, 'data' => $data]);
    }
}
