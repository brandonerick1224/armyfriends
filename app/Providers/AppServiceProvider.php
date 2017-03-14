<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * Define morph types (what's saved to {object}_type column)
         */
        Relation::morphMap([
            'user_profiles' => \App\Models\UserProfile::class,
            'album_items'   => \App\Models\AlbumItem::class,
            'posts'         => \App\Models\Post::class,
            'friends'       => \App\Models\Friend::class,
            'comments'      => \App\Models\Comment::class,
            'likes'         => \App\Models\Like::class,
            'messages'      => \App\Models\Message::class,
            'group_user'    => \App\Models\GroupUser::class,
            'user_tags'     => \App\Models\UserTag::class,
            'groups'        => \App\Models\Group::class,
        ]);

        // Default carbon format
        Carbon::setToStringFormat('m/d/Y');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerDevProviders();
    }

    /**
     * Register development and local enviroment service providers
     */
    private function registerDevProviders()
    {
        // Local enviroment enviroment service providers
        if ($this->app->environment('local')) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        // Local and development enviroment service providers
        if ($this->app->environment('local') || $this->app->environment('development')) {
            $this->app->register(\Barryvdh\Debugbar\ServiceProvider::class);
            //$this->app->register(\App\Services\ApiDebug\ApiDebugServiceProvider::class);
        }
    }
}
