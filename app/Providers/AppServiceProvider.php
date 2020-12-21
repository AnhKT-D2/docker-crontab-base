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
        $this->app->singleton(
            "App\Repositories\User\UserRepositoryInterface",
            "App\Repositories\User\UserRepository"
        );

        $this->app->singleton(
            "App\Repositories\Auth\AuthRepositoryInterface",
            "App\Repositories\Auth\AuthRepository"
        );

        $this->app->singleton(
            "App\Services\Auth\AuthServiceInterface",
            "App\Services\Auth\AuthService"
        );
        $this->app->singleton(
            "App\Services\Mail\MailServiceInterface",
            "App\Services\Mail\MailService"
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
