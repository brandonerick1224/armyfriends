<?php

namespace App\Models;

/**
 * Parent model class
 * 
 * Class Model
 *
 * @mixin \Eloquent
 */
class Model extends \Illuminate\Database\Eloquent\Model
{
    /**
     * Get unique object key
     *
     * @return string
     */
    public function getUniqueKey()
    {
        return $this->getMorphClass() . '-' . $this->id;
    }

    /**
     * Model array data
     *
     * @return string
     */
    public function getData()
    {
        return $this->toArray();
    }
}
