<?php

namespace App\Events;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

abstract class BroadcastToUserEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'event' => $this->getName(),
            'data'  => $this->getData(),
        ];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        // Use socket token as a channel
        $token = $this->user->socket_token;

        // Don't send to myself
        if ($this->user->id == auth()->id()) {
            return [];
        }

        // Check if token is in list of connected users
        if (! \Redis::sIsMember('users', $token)) {
            return [];
        }

        return [$token];
    }

    /**
     * Get event name
     *
     * @return mixed
     */
    public function getName()
    {
        return with(new \ReflectionClass($this))->getShortName();
    }

    /**
     * Get data for broadcasting
     */
    public function getData()
    {
        //
    }
}
