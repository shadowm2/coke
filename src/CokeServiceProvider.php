<?php

namespace Shadow\Coke;

use Illuminate\Support\ServiceProvider;

class CokeServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('coke', 'Shadow\Coke\Coke' );
    }
}
