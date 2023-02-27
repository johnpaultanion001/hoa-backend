<?php

namespace App\Providers;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Api\V1_0_0\Providers\RepositoryServiceProvider as Repository;
use Api\V1_0_0\Providers\AppServiceProvider as App;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
       (new Repository($this->app))->register();
       (new App($this->app))->register();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //

//        dd(time());
	    Schema::defaultStringLength(191);
    }
}
