<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Blade;
use Laravel\Passport\Passport;


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
        Blade::component('admin.components.alert', 'alert');
        Blade::component('admin.components.daterange', 'daterangeScipts'); 
        Schema::defaultStringLength(191);
        Passport::withCookieSerialization();
    }
    
}
