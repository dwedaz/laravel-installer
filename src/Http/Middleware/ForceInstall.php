<?php

namespace Dwedaz\LaravelInstaller\Http\Middleware;

use Closure;
use Redirect;

class ForceInstall
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
  
        if (!isset($request->segments()[0]) && !$this->alreadyInstalled() || !$this->alreadyInstalled() && $request->segments()[0] != 'install'){
            $routeName = 'laravel-installer::welcome';
            return redirect()->route($routeName);
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