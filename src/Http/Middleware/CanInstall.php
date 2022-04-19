<?php

namespace Dwedaz\LaravelInstaller\Http\Middleware;

use Closure;
use Redirect;

class CanInstall
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return \Illuminate\Http\RedirectResponse|mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->alreadyInstalled()) {
            $installedRedirect = config('laravel-installer.installedAlreadyAction');

            switch ($installedRedirect) {

                case 'route':
                    $routeName = config('laravel-installer.installed.redirectOptions.route.name');
                    $data = config('laravel-installer.installed.redirectOptions.route.message');

                    return redirect()->route($routeName)->with(['data' => $data]);
                    break;

                case 'abort':
                    abort(config('laravel-installer.installed.redirectOptions.abort.type'));
                    break;

                case 'dump':
                    $dump = config('laravel-installer.installed.redirectOptions.dump.data');
                    dd($dump);
                    break;

                case '404':
                case 'default':
                default:
                    abort(404);
                    break;
            }
        }

        return $next($request);
    }

    /**
     * If application is already installed.
     *
     * @return bool
     */
    public function alreadyInstalled()
    {   
       
        return file_exists(storage_path('installed'));
    }
}