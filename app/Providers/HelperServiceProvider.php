<?php

namespace App\Providers;

use Hamcrest\Util;
use Illuminate\Support\ServiceProvider;

class HelperServiceProvider extends ServiceProvider
{

    protected $helpers = [
        'Helper',
        'Constants',
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        foreach ($this->helpers as $helper) {
            $helper_path = app_path().'/Helpers/'.$helper.'.php';

            if (\File::isFile($helper_path)) {
                require_once $helper_path;
            }
        }
    }
}
