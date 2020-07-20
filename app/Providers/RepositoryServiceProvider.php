<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
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
        //user
        $this->app->bind(
            'App\Http\Controllers\Interfaces\User\AuthRepositoryInterface',
            'App\Http\Controllers\Eloquent\User\AuthRepository'
        );
        $this->app->bind(
            'App\Http\Controllers\Interfaces\User\HomeRepositoryInterface',
            'App\Http\Controllers\Eloquent\User\HomeRepository'
        );
        $this->app->bind(
            'App\Http\Controllers\Interfaces\User\OrdersRepositoryInterface',
            'App\Http\Controllers\Eloquent\User\OrdersRepository'
        );
        $this->app->bind(
            'App\Http\Controllers\Interfaces\User\UserRepositoryInterface',
            'App\Http\Controllers\Eloquent\User\UserRepository'
        );
    }
}
