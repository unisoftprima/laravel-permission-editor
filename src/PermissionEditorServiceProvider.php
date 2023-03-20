<?php

namespace Unisoft\LaravelPermissionEditor;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Unisoft\LaravelPermissionEditor\Http\Middleware\SpatiePermissionMiddleware;

class PermissionEditorServiceProvider extends ServiceProvider
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
    public function boot()
    {
        Route::prefix('permission-editor')
            ->as('permission-editor.')
            ->middleware(config('permission-editor.middleware', ['web', 'spatie-permission']))
            ->group(function () {
                $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
            });

        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('spatie-permission', SpatiePermissionMiddleware::class);

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'permission-editor');

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('permission-editor'),
            ], 'assets');

            $this->publishes([
                __DIR__.'/../config/permission-editor.php' => config_path('permission-editor.php'),
            ], 'permission-editor-config');

            //$this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->publishes([
                __DIR__ . '/../database/migrations/2023_01_01_100000_create_tasks_table.php' =>
                database_path('migrations/' . date('Y_m_d_His', time()) . '_create_tasks_table.php'),
 
                // More migration files here
            ], 'migrations');
        }
    }
}
