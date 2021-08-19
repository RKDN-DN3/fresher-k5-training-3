<?php

namespace App\Providers;


use Illuminate\Contracts\Auth\Access\Gate ;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         /* \App\Models\User::class => \App\Policies\UserPolicy::class, */
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot( )
    {
        $this->registerPolicies();
        Gate::before(function($user, $ability){
            if($user->isSuperAdmin()){
                return true;
            }
        });
        Passport::routes();
        //
    }
}
