<?php

namespace App\Events;

class CommentEvent extends BroadcastToListenersEvent
{
    /**
     * Get Redis listeners set key
     *
     * @return string
     */
    protected function getUniqueKey()
    {
        return $this->model->commentable->getUniqueKey();
    }
}
