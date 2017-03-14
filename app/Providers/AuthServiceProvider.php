<?php

namespace App\Providers;

use Illuminate\Contracts\Auth\Access\Gate as GateContract;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\Album::class => \App\Policies\AlbumPolicy::class,
        \App\Models\AlbumItem::class => \App\Policies\AlbumItemPolicy::class,
        \App\Models\Group::class => \App\Policies\GroupPolicy::class,
        \App\Models\GroupUser::class => \App\Policies\GroupUserPolicy::class,
        \App\Models\Post::class => \App\Policies\PostPolicy::class,
        \App\Models\UserTag::class => \App\Policies\UserTagPolicy::class,
        \App\Models\Comment::class => \App\Policies\CommentPolicy::class,
    ];

    /**
     * Register any application authentication / authorization services.
     *
     * @param  \Illuminate\Contracts\Auth\Access\Gate  $gate
     * @return void
     */
    public function boot(GateContract $gate)
    {
        $this->registerPolicies($gate);
    }
}
