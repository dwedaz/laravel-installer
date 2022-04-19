<?php

namespace Dwedaz\LaravelInstaller\Http\Controllers;

use Illuminate\Routing\Controller;


class FinalController extends Controller
{
    
    public function finish()
    {
        file_put_contents(storage_path('installed'),date('Y-m-d H:i:s'));
        return view('laravel-installer::finished',[]);
    }
}