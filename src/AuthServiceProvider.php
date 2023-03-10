<?php

namespace Versona0450\AuthLaramodule;

use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
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
        /**
         * Publish module
         */
        $this->publishes([
            __DIR__ . '/../stubs/Auth' => base_path('Modules/Auth'),
        ], 'auth-module');
    }
}
