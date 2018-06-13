<?php

namespace App\Providers;

use App\BusinessLogicLayer\PermissionsManager;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{


    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];




    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $permissionsManager = App::make(PermissionsManager::class);
        $permissionsManager->registerUserPolicies();

        Passport::routes();

    }
}
