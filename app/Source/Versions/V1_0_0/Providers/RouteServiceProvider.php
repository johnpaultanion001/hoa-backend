<?php

namespace Api\V1_0_0\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'Api\V1_0_0\Http\Controllers';

    /**
     * The version prefix of your routes
     * @var string
     */
    protected $version = 'v1.0.0';

    /**
     * The base directory of the app
     * @var string
     */
    protected $baseDir = 'Source/Versions/V1_0_0';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        //

        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {

        $this->mapRestfulApiRoutes();
        $this->mapAuthRoutes();
    }


    /**
     * Define the "ResfulApi" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapRestfulApiRoutes()
    {
        // ,
        Route::prefix($this->version . '/admin')
            ->namespace($this->namespace . '\\Admin')
             ->middleware(['auth:api', 'company','verify.company'])
            ->group(
                base_path('app/' . $this->baseDir . '/Routes/AdminRoutes.php')
            );


        Route::prefix($this->version . '/client')
            ->namespace($this->namespace . '\\Client')
            ->middleware(['company'])
            ->group(
                base_path('app/' . $this->baseDir . '/Routes/ClientRoutes.php')
            );
    }

    protected function mapAuthRoutes()
    {
        Route::prefix($this->version)
            ->namespace($this->namespace)
            ->middleware('auth:api')
            ->group(
                base_path('app/' . $this->baseDir . '/Routes/AuthRoutes.php')
            );
    }
}
