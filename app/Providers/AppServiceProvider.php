<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Helpers\GuidHelper;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(GuidHelper::class, function() { 
            return new GuidHelper(); 
        });
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
