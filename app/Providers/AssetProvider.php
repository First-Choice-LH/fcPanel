<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AssetProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            base_path('vendor/twitter/bootstrap/dist') => public_path('vendor/bootstrap'),
        ], 'public');

        $this->publishes([
            base_path('vendor/thomaspark/bootswatch/dist/simplex') => public_path('vendor/bootswatch/simplex'),
        ], 'public');

        $this->publishes([
            base_path('vendor/eternicode/bootstrap-datepicker/dist') => public_path('vendor/bootstrap-datepicker'),
        ], 'public');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
