<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton(\App\Core\Authentications\AuthenticateInterface::class, function () {
            return new \App\Core\Authentications\Authenticate();
        });
        $this->app->singleton(\App\Core\RegistrationInfo\RegistrationInfoInterface::class, function () {
            return new \App\Core\RegistrationInfo\RegistrationInfo();
        });
    }
}
