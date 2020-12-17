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
        $models = [
            'Auth'
        ];

        foreach ($models as $model) {
            $this->app->singleton(
                "App\Repositories\{$model}\{$model}RepositoryInterface",
                "App\Repositories\{$model}\{$model}Repository"
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
