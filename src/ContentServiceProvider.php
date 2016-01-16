<?php

namespace Minhbang\LaravelContent;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;

class ContentServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'content');
        $this->loadViewsFrom(__DIR__ . '/../views', 'content');
        $this->publishes(
            [
                __DIR__ . '/../views'                           => base_path('resources/views/vendor/content'),
                __DIR__ . '/../lang'                            => base_path('resources/lang/vendor/content'),
                __DIR__ . '/../config/content.php'             => config_path('content.php'),
                __DIR__ . '/../database/migrations/' .
                '2015_10_20_161102_create_contents_table.php' =>
                    database_path('migrations/2015_10_20_161102_create_contents_table.php'),
            ]
        );

        if (config('content.add_route') && !$this->app->routesAreCached()) {
            require __DIR__ . '/routes.php';
        }
        // pattern filters
        $router->pattern('content', '[0-9]+');
        // model bindings
        $router->model('content', 'Minhbang\LaravelContent\Content');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/content.php', 'content');
    }
}
