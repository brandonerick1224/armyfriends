<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);

        /**
         * Implicit models bindings
         */
        $router->model('user', \App\Models\User::class);
        $router->model('post', \App\Models\Post::class);
        $router->model('album', \App\Models\Album::class);
        $router->model('album_item', \App\Models\AlbumItem::class);
        $router->model('group', \App\Models\Group::class);
        $router->model('group_user', \App\Models\GroupUser::class);
        $router->model('user_tag', \App\Models\UserTag::class);
        $router->model('comment', \App\Models\Comment::class);
    }


    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        $this->mapWebRoutes($router);

        $this->mapApiRoutes($router);
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapWebRoutes(Router $router)
    {
        $router->group([
            'namespace' => $this->namespace, 'middleware' => 'web',
        ], function ($router) {
            require app_path('Http/routes.php');
        });
    }

    /**
     * Define the "api" routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    protected function mapApiRoutes(Router $router)
    {
        $router->group([
            'prefix'     => 'api',
            'namespace'  => $this->namespace . '\Api',
            'middleware' => 'api',
        ], function ($router) {
            require app_path('Http/api.php');
        });
    }
}
