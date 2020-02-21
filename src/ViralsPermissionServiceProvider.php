<?php

namespace ViralsInfyom\ViralsPermission;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use ViralsInfyom\ViralsPermission\Console\Commands\AddSidebarContent;
use ViralsInfyom\ViralsPermission\Console\Commands\PublishPermissionMiddleware;
use ViralsInfyom\ViralsPermission\Console\Commands\PublishViralsUserModel;
use ViralsInfyom\ViralsPermission\Models\Traits\CheckPermissionTrait;

class ViralsPermissionServiceProvider extends ServiceProvider
{
    use CheckPermissionTrait;
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

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadRoutesFrom(__DIR__.'/../routes/base.php');

        $this->registerMiddlewareGroup($this->app->router);

        $this->loadTranslationsFrom(__DIR__.'/../lang', 'virals-permission');

        $this->bladeCustom();

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

    public function publishesFile()
    {
        $this->publishes([
            __DIR__.'/../views' => base_path('resources/views/vendor/virals-permission'),
        ], 'views');

        $this->publishes([
            __DIR__.'/../lang' => base_path('resources/lang/vendor/virals-permission'),
        ], 'lang');
    }

    public function bladeCustom()
    {
        Blade::if('checkRoute', function ($route) {
            return $this->checkRoute($route);
        });
    }
}
