<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using class based composers...
        view()->composer('_sidebars.left', \App\Http\ViewComposers\SidebarLeftComposer::class);
        view()->composer('_sidebars.right', \App\Http\ViewComposers\SidebarRightComposer::class);
        view()->composer('_blocks.home-banner', \App\Http\ViewComposers\HomeBannerComposer::class);
        view()->composer([
            '_sidebars.left', 'settings.index', 'auth.register',
        ], \App\Http\ViewComposers\CountriesComposer::class);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}