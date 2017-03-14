<?php

namespace App\Events;

use App\Models\Model;
use App\Models\User;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Queue\SerializesModels;

abstract class BroadcastToListenersEvent extends Event implements ShouldBroadcastNow
{
    use SerializesModels;
    
    /**
     * Model model
     *
     * @var Model
     */
    public $model;

    /**
     * Action
     *
     * @var string
     */
    public $action;

    /**
     * Create a new event instance.
     *
     * @param Model  $model  Model
     * @param string $action Action
     */
    public function __construct(Model $model, $action = null)
    {
        $this->model  = $model;
        $this->action = $action;
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['event' => $this->getName(), 'data' => $this->getData()];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        /** @var User $me */
        $me = auth()->user();

        $tokens = \Redis::sMembers($this->getUniqueKey());

        // Remove sender user from from the list
        if (($key = array_search($me->socket_token, $tokens)) !== false) {
            unset($tokens[$key]);
        }

        return $tokens;
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
        return [
            'key'    => $this->getUniqueKey(),
            'action' => $this->action,
            'data'   => $this->model->getData(),
        ];
    }

    /**
     * Get Redis listeners set key
     *
     * @return string
     */
    protected function getUniqueKey()
    {
        return $this->model->getUniqueKey();
    }
}
