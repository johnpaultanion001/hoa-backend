<?php

namespace App\Providers;

use Api\Facade\Auth\FirebaseAuth;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider {


    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [

    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(FirebaseAuth $firebaseAuth) {
        $this->registerPolicies();

        $firebaseAuth->guard();
    }
}
