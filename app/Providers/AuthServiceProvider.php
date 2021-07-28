<?php

namespace App\Providers;

use App\BusinessLogicLayer\CrowdSourcingProject\CrowdSourcingProjectAccessManager;
use App\BusinessLogicLayer\UserRoleManager;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\App;

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

        $permissionsManager = App::make(UserRoleManager::class);
        $permissionsManager->registerUserPolicies();

        $crowdSourcingProjectAccessManager = App::make(CrowdSourcingProjectAccessManager::class);
        $crowdSourcingProjectAccessManager->registerCrowdSourcingProjectPolicies();

    }
}
