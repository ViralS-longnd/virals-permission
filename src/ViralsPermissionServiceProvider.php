<?php

namespace ViralsInfyom\ViralsPermission;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use ViralsInfyom\ViralsPermission\Console\Commands\AddSidebarContent;
use ViralsInfyom\ViralsPermission\Console\Commands\PublishPermissionMiddleware;
use ViralsInfyom\ViralsPermission\Console\Commands\PublishViralsUserModel;

class ViralsPermissionServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                AddSidebarContent::class,
                PublishPermissionMiddleware::class,
                PublishViralsUserModel::class,
            ]);
        }

        $this->loadViewsFrom(__DIR__.'/../views', 'virals-permission');
        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/virals-permission'),
        ]);

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes/base.php');

        $this->registerMiddlewareGroup($this->app->router);

    }

    public function registerMiddlewareGroup(Router $router)
    {
        $middleware_key = 'check-permission';
        $middleware_class = [
            \App\Http\Middleware\Authenticate::class,
            \App\Http\Middleware\CheckPermissionMiddleware::class,
        ];

        if (!is_array($middleware_class)) {
            $router->pushMiddlewareToGroup($middleware_key, $middleware_class);

            return;
        }

        foreach ($middleware_class as $middleware_class) {
            $router->pushMiddlewareToGroup($middleware_key, $middleware_class);
        }
    }
}
