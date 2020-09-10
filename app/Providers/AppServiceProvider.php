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
            \App\Repositories\Brand\BrandRepositoryInterface::class,
            \App\Repositories\Brand\BrandRepository::class
        );
        $this->app->singleton(
            \App\Repositories\Contact\ContactRepositoryInterface::class,
            \App\Repositories\Contact\ContactRepository::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', function($view){
            $view->with('auth_check', \Auth::check())
                ->with('auth_user', \Auth::user());
        });
    }
}
