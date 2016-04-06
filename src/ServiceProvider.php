<?php

namespace Minhbang\Content;

use Illuminate\Routing\Router;
use Minhbang\Kit\Extensions\BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @param \Illuminate\Routing\Router $router
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->loadTranslationsFrom(__DIR__ . '/../lang', 'content');
        $this->loadViewsFrom(__DIR__ . '/../views', 'content');
        $this->publishes(
            [
                __DIR__ . '/../views'              => base_path('resources/views/vendor/content'),
                __DIR__ . '/../lang'               => base_path('resources/lang/vendor/content'),
                __DIR__ . '/../config/content.php' => config_path('content.php'),
            ]
        );
        $this->publishes(
            [
                __DIR__ . '/../database/migrations/2015_10_20_161102_create_contents_table.php' =>
                    database_path('migrations/2015_10_20_161102_create_contents_table.php'),
                __DIR__ . '/../database/migrations/2015_10_20_171102_create_content_translations_table.php' =>
                    database_path('migrations/2015_10_20_171102_create_content_translations_table.php'),
            ],
            'db'
        );
        
        $this->mapWebRoutes($router, __DIR__ . '/routes.php', config('content.add_route'));
        
        // pattern filters
        $router->pattern('content', '[0-9]+');
        // model bindings
        $router->model('content', 'Minhbang\Content\Content');
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
