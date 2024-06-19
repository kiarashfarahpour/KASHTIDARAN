<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Schema;

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

//        $this->app->bind('path.public', function() {
//            return realpath(base_path().'/../public_html');
//        });

        Schema::defaultStringLength(191);
//		error_reporting(E_ALL);
//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);
    }
}
