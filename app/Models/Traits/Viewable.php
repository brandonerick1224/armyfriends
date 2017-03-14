<?php

namespace App\Models\Traits;

use App\Models\View;
use Illuminate\Database\Eloquent\Builder;

trait Viewable
{
    /**
     * Should be removed on model delete
     *
     * @var bool
     */
    protected static $removeViewsOnDelete = true;

    /**
     * Boot the soft taggable trait for a model.
     *
     * @return void
     */
    public static function bootViewable()
    {
        if (static::$removeViewsOnDelete) {
            static::deleting(function ($model) {
                $model->removeViews();
            });
        }
    }

    /**
     * Delete views related to the current record
     */
    public function removeViews()
    {
        foreach ($this->views as $view) {
            $view->delete();
        }
    }

    /**
     * Fetch records that are viewed by a given user.
     * Ex: Book::whereViwedBy(123)->get();
     *
     * @param Builder $query
     * @param null $userId
     * @return Builder
     */
    public function scopeWhereViewedBy($query, $userId = null)
    {
        if (is_null($userId)) {
            $userId = auth()->id();
        }

        return $query->whereHas('views', function ($q) use ($userId) {
            $q->where('user_id', '=', $userId);
        });
    }

    /**
     * Collection of the views on this record
     */
    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    /**
     * Add a view for this record by the given user.
     *
     * @param $userId mixed - If null will use currently logged in user.
     */
    public function view($userId = null)
    {
        if (is_null($userId)) {
            $userId = auth()->id();
        }


        if ($userId) {
            $view = $this->views()
                         ->where('user_id', '=', $userId)
                         ->first();

            if ($view) {
                $view->touch();
                return;
            }

            $view          = new View();
            $view->user_id = $userId;
            $this->views()->save($view);
        }

        $this->increment('views_count');
    }

    /**
     * Use short class name for type
     *
     * @return string
     */
    public function getViewableTypeAttribute()
    {
        return (new \ReflectionClass($this))->getShortName();
    }
}
