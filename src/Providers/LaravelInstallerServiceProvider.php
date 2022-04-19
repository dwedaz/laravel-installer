<?php

namespace Dwedaz\LaravelInstaller\Providers;

use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Dwedaz\LaravelInstaller\Http\Middleware\CanInstall;
use Dwedaz\LaravelInstaller\Http\Middleware\ForceInstall;

class LaravelInstallerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laravel-installer');
    }
  
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laravel-installer');
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-installer');
        $router = $this->app->make(Router::class);
        $router->aliasMiddleware('install', CanInstall::class);
        if ($this->app->runningInConsole()) {

            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('laravel-installer.php'),
            ], 'config');

            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('laravel-installer'),
            ], 'assets');
        
        }
    }
}
